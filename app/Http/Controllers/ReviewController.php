<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /** Store a product review (auth users auto-approved, guests pending). */
    public function store(Request $request, int $productId)
    {
        $product = Product::findOrFail($productId);

        $data = $request->validate([
            'rating'  => 'required|integer|between:1,5',
            'comment' => 'required|string|min:5|max:1000',
            'name'    => 'nullable|string|max:120',
        ]);

        Review::create([
            'product_id'  => $product->id,
            'user_id'     => auth()->id(),
            'author_name' => auth()->check() ? auth()->user()->name : trim((string) ($data['name'] ?? __('messages.guest'))),
            'rating'      => (int) $data['rating'],
            'comment'     => $data['comment'],
            'status'      => auth()->check() ? 'approved' : 'pending',
        ]);

        $msg = auth()->check() ? __('messages.review_added') : __('messages.review_pending');
        return back()->with('ok', $msg);
    }
}
