<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class LeadController extends Controller
{
    /**
     * Danh sách khách hàng tiềm năng gửi form báo giá / tư vấn.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status');

        $query = DB::table('leads')
            ->leftJoin('products', 'leads.product_id', '=', 'products.id')
            ->select([
                'leads.*',
                'products.name as product_name',
            ]);

        if ($status && in_array($status, ['new', 'contacted', 'converted', 'rejected'])) {
            $query->where('leads.status', $status);
        }

        $leads = $query->orderBy('leads.created_at', 'desc')->paginate(20);

        return view('admin.leads.index', [
            'leads' => $leads,
            'currentStatus' => $status,
        ]);
    }

    /**
     * Cập nhật trạng thái xử lý Lead.
     */
    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'status' => ['required', 'in:new,contacted,converted,rejected'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        DB::table('leads')->where('id', $id)->update([
            'status' => $request->input('status'),
            'note' => $request->input('note'),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Đã cập nhật trạng thái khách hàng tiềm năng thành công.');
    }
}
