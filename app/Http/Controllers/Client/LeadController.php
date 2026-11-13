<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeadController extends Controller
{
    /**
     * Tiếp nhận và xử lý yêu cầu báo giá lăn bánh hoặc tư vấn.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'regex:/^(0[3|5|7|8|9])[0-9]{8}$/'],
            'email' => ['nullable', 'email', 'max:255'],
            'type' => ['nullable', 'string', 'in:quote,consultation,test_drive,contact'],
            'product_id' => ['nullable', 'integer'],
            'message' => ['nullable', 'string', 'max:1000'],
            'registration_area' => ['nullable', 'string', 'max:100'],
        ], [
            'name.required' => 'Vui lòng nhập họ và tên của bạn.',
            'phone.required' => 'Vui lòng nhập số điện thoại liên hệ.',
            'phone.regex' => 'Số điện thoại không đúng định dạng di động Việt Nam.',
        ]);

        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();

        DB::transaction(function () use ($validated, $ipAddress, $userAgent, $request) {
            // 1. Lưu bản ghi đồng ý xử lý dữ liệu
            $consentId = DB::table('consent_records')->insertGetId([
                'type' => 'data_processing',
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'source_url' => $request->headers->get('referer'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Ghi chú chi tiết khu vực nếu có
            $extraMessage = $validated['message'] ?? '';
            if (! empty($validated['registration_area'])) {
                $extraMessage .= ' | Khu vực biển số: '.$validated['registration_area'];
            }

            // 2. Lưu lead khách hàng
            $leadId = DB::table('leads')->insertGetId([
                'type' => $validated['type'] ?? 'quote',
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'] ?? null,
                'product_id' => $validated['product_id'] ?? null,
                'source_url' => $request->headers->get('referer'),
                'status' => 'new',
                'message' => trim($extraMessage),
                'consent_id' => $consentId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // 3. Ghi lịch sử trạng thái ban đầu
            DB::table('lead_status_histories')->insert([
                'lead_id' => $leadId,
                'status' => 'new',
                'note' => 'Khách hàng gửi yêu cầu từ website VinFast Hải Phòng',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return back()->with('success', 'Yêu cầu của bạn đã được gửi thành công! Chuyên viên tư vấn VinFast Hải Phòng sẽ liên hệ trong ít phút.');
    }
}
