<?php

namespace App\Http\Controllers;

use App\Models\{Order, Menu, Discount, OrderItem};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function store(Request $request) {
        $data = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.menu_id' => ['required','integer', Rule::exists('menus','id')],
            'items.*.quantity' => 'required|integer|min:1',
            'discount_code' => 'nullable|string'
        ]);

        $user = $request->user();

        return DB::transaction(function() use ($data, $user) {
            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'pending',
            ]);

            $subtotal = 0;

            foreach ($data['items'] as $item) {
                $menu = Menu::find($item['menu_id']);
                $qty  = $item['quantity'];
                $line = $menu->price * $qty;

                OrderItem::create([
                    'order_id'   => $order->id,
                    'menu_id'    => $menu->id,
                    'quantity'   => $qty,
                    'unit_price' => $menu->price,
                    'line_total' => $line,
                ]);

                $subtotal += $line;
            }

            $final = $subtotal;
            $discount = null;

            if (!empty($data['discount_code'])) {
                $discount = Discount::where('code', $data['discount_code'])
                    ->where('active', true)
                    ->when(true, function($q){
                        $q->where(function($qq){
                            $qq->whereNull('expires_at')
                               ->orWhere('expires_at','>', now());
                        });
                    })
                    ->first();

                if (!$discount) {
                    abort(422, 'Invalid or expired discount code.');
                }

                if ($discount->usage_limit && $discount->times_used >= $discount->usage_limit) {
                    abort(422, 'Discount usage limit reached.');
                }

                if ($discount->min_order_amount && $subtotal < $discount->min_order_amount) {
                    abort(422, 'Order total too low for this discount.');
                }

                if ($discount->type === 'percent') {
                    $final = max(0, $subtotal - ($subtotal * ($discount->value/100)));
                } else {
                    $final = max(0, $subtotal - $discount->value);
                }

                $order->discount()->associate($discount);
            }

            $order->total_amount = $subtotal;
            $order->final_amount = $final;
            $order->save();

            return $order->load('menus');
        });
    }

    //این قسمت فقط ادمین میتونه وضعیت سفارش رو تغییر بده
    public function updateStatus(Request $request, Order $order) {
        if ($request->user()->role !== 'admin') abort(403);
        $data = $request->validate([
            'status' => 'required|in:pending,paid,completed,cancelled'
        ]);
        $order->update(['status'=>$data['status']]);
        return $order;
    }

    public function show(Order $order) {
        $this->authorizeView($order);
        return $order->load('menus','paymentHistory','discount');
    }

    public function myOrders(Request $request) {
        return Order::where('user_id', $request->user()->id)
            ->with('menus')
            ->latest()->paginate(20);
    }

    private function authorizeView(Order $order) {
        if (auth()->user()->role !== 'admin' && $order->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
