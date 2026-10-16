<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /** All categories — editorial index */
    public function index()
    {
        return view('categories', [
            'categories' => Category::with('subcategories')->withCount('products')->get(),
        ]);
    }

    /** One category landing page with subcategory filter */
    public function show(Request $request, string $slug)
    {
        $category = Category::with(['subcategories' => fn ($q) => $q->withCount('products')])
            ->withCount('products')
            ->where('slug', $slug)
            ->firstOrFail();
        $sub = (string) $request->query('sub', 'all');

        $query = Product::with('subcategory')->where('category_id', $category->id);
        if ($sub !== 'all') {
            $query->whereHas('subcategory', fn ($s) => $s->where('slug', $sub));
        }
        $query->latest();

        return view('category', [
            'category'  => $category,
            'products'  => $query->get(),
            'activeSub' => $sub,
            'others'    => Category::where('slug', '!=', $slug)->withCount('products')->take(4)->get(),
        ]);
    }
}
