<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * Hiển thị trang liên hệ VinFast Hải Phòng.
     */
    public function index(): View
    {
        return view('clients.pages.contact.index');
    }

    /**
     * Tiếp nhận tin nhắn từ form liên hệ.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
            'phone' => ['required', 'string', 'regex:/^(0[3|5|7|8|9])+([0-9]{8})$/'],
            'email' => ['nullable', 'email', 'max:150'],
            'subject' => ['nullable', 'string', 'max:200'],
            'message' => ['required', 'string', 'min:5', 'max:2000'],
        ], [
            'name.required' => 'Vui lòng nhập họ và tên của bạn.',
            'phone.required' => 'Vui lòng cung cấp số điện thoại.',
            'phone.regex' => 'Số điện thoại không đúng định dạng Việt Nam.',
            'message.required' => 'Vui lòng nhập nội dung cần liên hệ.',
        ]);

        $now = now();

        DB::table('contact_messages')->insert([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'subject' => $validated['subject'] ?? 'Khách hàng gửi liên hệ từ website',
            'message' => $validated['message'],
            'ip_address' => $request->ip() ?? '127.0.0.1',
            'is_read' => false,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return redirect()->back()->with('success', 'Cảm ơn Quý khách! Lời nhắn của Quý khách đã được gửi tới Ban quản lý Showroom VinFast Minh Đạo. Chúng tôi sẽ phản hồi trong thời gian sớm nhất.');
    }
}
