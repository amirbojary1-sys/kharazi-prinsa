<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    /** Public order tracking by code + phone. */
    public function show()
    {
        return view('track');
    }

    public function lookup(Request $request)
    {
        $data = $request->validate([
            'code'  => 'required|string|max:20',
            'phone' => 'required|string|max:30',
        ]);

        $order = Order::with('items')
            ->where('code', trim($data['code']))
            ->where('phone', trim($data['phone']))
            ->first();

        if (!$order) {
            return back()->withErrors(['code' => __('messages.track_not_found')])->withInput();
        }
        return view('track', compact('order'));
    }
}
