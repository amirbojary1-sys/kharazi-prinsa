<?php

namespace App\Http\Controllers;

use App\Support\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('cart');
    }

    public function add(Request $request, int $id)
    {
        Cart::add($id, max(1, (int) $request->input('qty', 1)));
        if ($request->input('buy')) {
            return redirect()->route('checkout');
        }
        return redirect()->back()->with('ok', __('messages.added_to_cart'))->with('added', 1);
    }

    public function update(Request $request)
    {
        foreach ((array) $request->input('qty', []) as $id => $qty) {
            Cart::update((int) $id, (int) $qty);
        }
        return back()->with('ok', __('messages.qty_updated'));
    }

    public function remove(int $id)
    {
        Cart::remove($id);
        return back();
    }

    public function applyCoupon(Request $request)
    {
        $code = trim((string) $request->input('code', ''));
        if ($code === '') {
            return back()->with('error', __('messages.coupon_invalid'));
        }
        $res = Cart::applyCoupon($code);
        return back()->with($res['ok'] ? 'ok' : 'error', $res['msg']);
    }

    public function removeCoupon()
    {
        Cart::removeCoupon();
        return back()->with('ok', __('messages.coupon_removed'));
    }
}
