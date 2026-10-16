<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'categories'    => \App\Models\Category::with('subcategories')->withCount('products')->get(),
            'subcategories' => \App\Models\Subcategory::with('category')->withCount('products')->get(),
            'featured'      => Product::where('featured', true)->take(8)->get(),
        ]);
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function sendContact(Request $request)
    {
        $request->validate(['name' => 'required', 'message' => 'required']);
        return redirect()->route('contact')->with('ok', __('messages.msg_sent'));
    }

    public function lang($locale)
    {
        if (in_array($locale, ['fa', 'en'], true)) {
            session(['lang' => $locale]);
        }
        return back();
    }
}
