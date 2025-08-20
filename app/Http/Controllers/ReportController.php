<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    //گزارش وضعیت سفارش‌ها با فیلتر وضعیت
    public function ordersByStatus(Request $request) {
        $status = $request->query('status');
        $query = DB::table('orders')
            ->select('status', DB::raw('COUNT(*) as count'), DB::raw('SUM(final_amount) as total'))
            ->groupBy('status');

        if ($status) {
            $query->where('status', $status);
        }

        return $query->get();
    }

    //غذاهای پرطرفدار
    public function popularMenus() {
        return DB::table('order_items')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->select('menus.id','menus.name', DB::raw('SUM(order_items.quantity) as total_qty'))
            ->groupBy('menus.id','menus.name')
            ->orderByDesc('total_qty')
            ->limit(20)
            ->get();
    }

    // 3) گزارش پرداخت‌ها: مجموع، میانگین، تعداد
    public function paymentsSummary() {
        return DB::table('payment_histories')->selectRaw('
            COUNT(*) as count,
            SUM(amount) as total_amount,
            AVG(amount) as avg_amount
        ')->get()->first();
    }
}
