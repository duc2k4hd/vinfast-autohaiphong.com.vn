<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Bảng điều khiển tổng quan Admin.
     */
    public function index(): View
    {
        $totalCars = DB::table('products')->count();
        $totalLeads = DB::table('leads')->count();
        $newLeads = DB::table('leads')->where('status', 'new')->count();
        $totalOrders = DB::table('orders')->count();
        $pendingCashOrders = DB::table('orders')->where('payment_status', 'unpaid')->count();
        $totalOrderValue = DB::table('orders')->sum('total');

        $recentOrders = DB::table('orders')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentLeads = DB::table('leads')
            ->leftJoin('products', 'leads.product_id', '=', 'products.id')
            ->select([
                'leads.*',
                'products.name as product_name',
            ])
            ->orderBy('leads.created_at', 'desc')
            ->limit(5)
            ->get();

        $dailyStats = collect();
        for ($i = 6; $i >= 0; $i--) {
            $targetDate = now()->subDays($i);
            $date = $targetDate->format('Y-m-d');
            $label = $targetDate->format('d/m');
            $ordersCount = DB::table('orders')->whereDate('created_at', $date)->count();
            $leadsCount = DB::table('leads')->whereDate('created_at', $date)->count();
            $dailyStats->push([
                'date' => $date,
                'label' => $label,
                'orders' => $ordersCount,
                'leads' => $leadsCount,
            ]);
        }

        $maxDailyVal = max(1, (int) $dailyStats->max(fn ($d) => max($d['orders'], $d['leads'])));

        return view('admin.dashboard.index', [
            'totalCars' => $totalCars,
            'totalLeads' => $totalLeads,
            'newLeads' => $newLeads,
            'totalOrders' => $totalOrders,
            'pendingCashOrders' => $pendingCashOrders,
            'totalOrderValue' => $totalOrderValue,
            'recentOrders' => $recentOrders,
            'recentLeads' => $recentLeads,
            'dailyStats' => $dailyStats,
            'maxDailyVal' => $maxDailyVal,
        ]);
    }
}
