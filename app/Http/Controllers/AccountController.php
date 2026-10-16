<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    /** My account: profile + latest orders. */
    public function index()
    {
        $user   = auth()->user();
        $orders = Order::with('items')->where('user_id', $user->id)->latest()->get();
        return view('account.index', compact('user', 'orders'));
    }

    /** One of the logged-in user's orders. */
    public function order(int $id)
    {
        $order = Order::with('items')->where('user_id', auth()->id())->findOrFail($id);
        return view('account.order', compact('order'));
    }

    public function updateProfile(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:80',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($request->filled('new_password')) {
            $request->validate([
                'new_password' => 'required|string|min:6|confirmed',
                'password'     => 'required|string',
            ]);
            if (!Hash::check($request->input('password'), auth()->user()->password)) {
                return back()->withErrors(['password' => __('messages.wrong_password')])->withInput();
            }
            $data['password'] = Hash::make($request->input('new_password'));
        }

        auth()->user()->update($data);
        return back()->with('ok', __('messages.profile_saved'));
    }
}
