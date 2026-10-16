<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\PaymentGateway;
use App\Support\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function show()
    {
        if (Cart::count() === 0) {
            return redirect()->route('cart');
        }
        return view('checkout');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:120',
            'phone'   => 'required|string|max:30',
            'email'   => 'nullable|email|max:120',
            'address' => 'required|string|max:255',
            'city'    => 'required|string|max:80',
            'zip'     => 'nullable|string|max:20',
            'notes'   => 'nullable|string|max:500',
            'pay'     => 'required|in:online,cod,card',
        ]);

        if (Cart::count() === 0) {
            return redirect()->route('cart');
        }

        $coupon  = Cart::coupon();
        $order = DB::transaction(function () use ($data, $coupon) {
            $order = Order::create([
                'user_id'        => auth()->id(),
                'code'          => Order::nextCode(),
                'customer_name' => $data['name'],
                'phone'         => $data['phone'],
                'email'         => $data['email'] ?? null,
                'address'       => $data['address'],
                'city'          => $data['city'],
                'zip'           => $data['zip'] ?? null,
                'notes'         => $data['notes'] ?? null,
                'pay_method'    => $data['pay'],
                'status'        => 'pending',   // online → paid after gateway verify
                'subtotal'      => Cart::subtotal(),
                'discount'      => Cart::discount(),
                'coupon_code'   => $coupon?->code,
                'shipping'      => Cart::shipping(),
                'total'         => Cart::total(),
            ]);

            foreach (Cart::lines() as $line) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $line->product->id,
                    'name_fa'    => $line->product->name_fa,
                    'name_en'    => $line->product->name_en,
                    'price'      => $line->product->price,
                    'qty'        => $line->qty,
                    'image'      => $line->product->image,
                ]);

                $p = Product::find($line->product->id);
                $p->stock = max(0, $p->stock - $line->qty);
                $p->save();
            }

            return $order;
        });

        Cart::clear();

        if ($data['pay'] === 'online') {
            return redirect()->to(PaymentGateway::start($order));
        }

        return redirect()->route('order.success', $order->code);
    }

    public function success(string $code)
    {
        $order = Order::with('items')->where('code', $code)->firstOrFail();
        return view('order-success', compact('order'));
    }
}
