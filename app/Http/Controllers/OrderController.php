<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use App\Models\Discount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * بررسی و نمایش صفحه‌ی checkout
     */
    public function checkout(Request $request)
    {
        $orderId = $request->input('order_id');

        // اگر سفارش موجود نیست، بساز
        if (!$orderId) {
            $order = Order::create([
                'user_id'     => Auth::id(),
                'status'      => 'pending',
                'total_price' => 0,
            ]);
        } else {
            $order = Order::with('items.menu')->findOrFail($orderId);
        }

        // اگر کاربر کد تخفیف وارد کرده باشد
        if ($request->filled('discount_code')) {
            $discount = Discount::where('code', $request->discount_code)
                ->where('expires_at', '>', now())
                ->first();

            if ($discount) {
                $order->discount_id = $discount->id;
                $order->discount_amount = $discount->amount;
                $order->save();

                return redirect()
                    ->route('order.checkout', ['order_id' => $order->id])
                    ->with('success', 'کد تخفیف با موفقیت اعمال شد.');
            } else {
                return redirect()
                    ->back()
                    ->with('error', 'کد تخفیف معتبر نیست یا منقضی شده است.');
            }
        }

        return view('orders.checkout', compact('order'));
    }

    /**
     * ثبت سفارش سریع
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'menu_id'  => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            // ایجاد سفارش جدید
            $order = Order::create([
                'user_id'     => Auth::id(),
                'status'      => 'pending',
                'total_price' => 0,
            ]);

            // افزودن آیتم سفارش
            $menu = Menu::findOrFail($request->menu_id);

            OrderItem::create([
                'order_id' => $order->id,
                'menu_id'  => $menu->id,
                'quantity' => $request->quantity,
                'price'    => $menu->price,
            ]);

            // محاسبه قیمت کل
            $total = $menu->price * $request->quantity;
            $order->total_price = $total;
            $order->save();

            DB::commit();

            return redirect()->route('order.checkout', ['order_id' => $order->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'مشکلی در ثبت سفارش رخ داد: ' . $e->getMessage());
        }
    }
}
