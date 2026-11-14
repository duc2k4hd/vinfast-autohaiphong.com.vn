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
     * Danh sách khách hàng tiềm năng gửi form báo giá / tư vấn kèm bộ lọc tìm kiếm.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $productId = $request->query('product_id');
        $search = $request->query('search');

        $query = DB::table('leads')
            ->leftJoin('products', 'leads.product_id', '=', 'products.id')
            ->select([
                'leads.*',
                'products.name as product_name',
            ]);

        if ($status && in_array($status, ['new', 'contacted', 'converted', 'rejected'])) {
            $query->where('leads.status', $status);
        }

        if ($productId) {
            $query->where('leads.product_id', (int) $productId);
        }

        if (! empty($search)) {
            $cleanSearch = trim($search);
            $query->where(function ($q) use ($cleanSearch) {
                $q->where('leads.name', 'like', "%{$cleanSearch}%")
                    ->orWhere('leads.phone', 'like', "%{$cleanSearch}%")
                    ->orWhere('leads.email', 'like', "%{$cleanSearch}%");
            });
        }

        $leads = $query->orderBy('leads.created_at', 'desc')->paginate(20)->withQueryString();
        $products = DB::table('products')->select(['id', 'name'])->orderBy('sort_order', 'asc')->get();

        return view('admin.leads.index', [
            'leads' => $leads,
            'currentStatus' => $status,
            'currentProductId' => $productId,
            'currentSearch' => $search,
            'products' => $products,
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

        $updateData = [
            'status' => $request->input('status'),
            'updated_at' => now(),
        ];

        if ($request->filled('note') || $request->filled('message')) {
            $updateData['message'] = $request->input('note') ?? $request->input('message');
        }

        DB::table('leads')->where('id', $id)->update($updateData);

        return back()->with('success', 'Đã cập nhật trạng thái khách hàng tiềm năng thành công.');
    }

    /**
     * Xóa yêu cầu tư vấn / spam lead.
     */
    public function destroy(int $id): RedirectResponse
    {
        DB::table('leads')->where('id', $id)->delete();

        return back()->with('success', 'Đã xóa yêu cầu tư vấn thành công.');
    }
}
