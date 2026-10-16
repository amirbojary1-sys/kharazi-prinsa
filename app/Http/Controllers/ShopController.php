<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $q    = (string) $request->query('q', '');
        $cat  = (string) $request->query('cat', 'all');
        $sub  = (string) $request->query('sub', 'all');
        $sort = (string) $request->query('sort', 'new');

        $query = Product::with('category', 'subcategory');

        if ($cat !== 'all') {
            $query->whereHas('category', fn ($c) => $c->where('slug', $cat));
        }
        if ($sub !== 'all') {
            $query->whereHas('subcategory', fn ($s) => $s->where('slug', $sub));
        }
        if ($q !== '') {
            $query->where(function ($w) use ($q) {
                $w->where('name_fa', 'like', "%{$q}%")
                  ->orWhere('name_en', 'like', "%{$q}%")
                  ->orWhere('desc_fa', 'like', "%{$q}%")
                  ->orWhere('desc_en', 'like', "%{$q}%");
            });
        }

        match ($sort) {
            'price_asc'  => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'name'       => $query->orderBy('name_fa'),
            default      => $query->latest(),
        };

        $categories = Category::with('subcategories')->withCount('products')->get();

        return view('shop', [
            'products'   => $query->get(),
            'categories' => $categories,
            'activeCat'  => $cat,
            'activeSub'  => $sub,
            'subList'    => $cat !== 'all' ? ($categories->firstWhere('slug', $cat)?->subcategories ?? collect()) : Subcategory::withCount('products')->get(),
            'q'          => $q,
            'sort'       => $sort,
        ]);
    }

    public function show($id)
    {
        $product = Product::with('category', 'subcategory')->findOrFail($id);
        $related = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('product', compact('product', 'related'));
    }
}
