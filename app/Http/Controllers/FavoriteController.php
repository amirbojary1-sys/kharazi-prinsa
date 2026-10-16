<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Support\Favs;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle(Request $request, int $id)
    {
        $added = Favs::toggle($id);

        if ($request->wantsJson() || $request->input('ajax')) {
            return response()->json(['ok' => true, 'added' => $added, 'count' => Favs::count()]);
        }
        return back()->with('ok', $added ? __('messages.fav_added') : __('messages.fav_removed'));
    }

    public function index()
    {
        $products = Favs::products();
        return view('favorites.index', compact('products'));
    }
}
