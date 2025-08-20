<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function pay(Request $request, Order $order)
    {
        // فقط صاحب سفارش یا ادمین
        if ($request->user()->role !== 'admin' && $order->user_id !== $request->user()->id) {
            abort(403);
        }

        if ($order->status !== 'pending') {
            return response()->json(['message'=>'Order is not payable'], 422);
        }

        return DB::transaction(function () use ($order, $request) {
            // شبیه‌سازی موفقیت پرداخت
            $payment = PaymentHistory::create([
                'order_id' => $order->id,
                'user_id'  => $request->user()->id,
                'amount'   => $order->final_amount,
                'method'   => 'online',
                'status'   => 'success',
                'transaction_id' => 'TX-'.uniqid(),
                'paid_at'  => now(),
            ]);

            $order->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);

            if ($order->discount) {
                $order->discount->increment('times_used');
            }

            return $order->load('paymentHistory');
        });
    }
}
