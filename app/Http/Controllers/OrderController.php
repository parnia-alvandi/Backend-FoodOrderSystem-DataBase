<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;

class OrderController extends Controller
{
    /**
     * نمایش صفحه‌ی مرور سفارش (اختیاری)
     */
    public function checkout(Request $request)
    {
        $menuId   = $request->input('menu_id');
        $quantity = $request->input('quantity', 1);

        $menu = Menu::findOrFail($menuId);
        $total = $menu->price * $quantity;

        return view('orders.checkout', compact('menu', 'quantity', 'total'));
    }

    /**
     * ایجاد سفارش جدید و انتقال به پرداخت
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'menu_id'  => 'required|exists:menus,id',
            'quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            // ایجاد سفارش
            $order = Order::create([
                'user_id'     => Auth::id(),
                'status'      => 'pending',
                'total_price' => 0,
            ]);

            // آیتم سفارش
            $menu = Menu::findOrFail($request->menu_id);

            OrderItem::create([
                'order_id' => $order->id,
                'menu_id'  => $menu->id,
                'quantity' => $request->quantity,
                'price'    => $menu->price,
            ]);

            // محاسبه و ذخیره قیمت کل
            $order->total_price = $menu->price * $request->quantity;
            $order->save();

            DB::commit();

            // ✅ بعد از سفارش مستقیم برو به پرداخت
            return redirect()->route('payment.process', ['order_id' => $order->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'مشکلی در ثبت سفارش رخ داد: ' . $e->getMessage());
        }
    }
}
