<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class PaymentController extends Controller
{
    /**
     * پردازش پرداخت سفارش
     */
    public function process($order_id)
    {
        $order = Order::findOrFail($order_id);

        // 🔹 اینجا می‌تونی اتصال به درگاه واقعی رو شبیه‌سازی یا پیاده‌سازی کنی
        // فعلاً برای تست، ما پرداخت موفق رو شبیه‌سازی می‌کنیم:
        $status = "success";

        // بعد از شبیه‌سازی پرداخت، کاربر رو می‌فرستیم به result
        return redirect()->route('payment.result', [
            'status'   => $status,
            'order_id' => $order->id
        ]);
    }

    /**
     * نمایش نتیجه پرداخت
     */
    public function result($status, $order_id)
    {
        $order = Order::findOrFail($order_id);

        // 🔹 مسیر ویو تغییر داده شده به "payment/result.blade.php"
        return view('payment.result', [
            'status' => $status,
            'order'  => $order,
        ]);
    }
}
