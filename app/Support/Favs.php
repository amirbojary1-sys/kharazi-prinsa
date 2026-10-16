<?php

namespace App\Support;

use App\Models\Favorite;
use App\Models\Product;

/**
 * Favorites: DB rows for logged-in users, session ids for guests.
 */
class Favs
{
    /** @return int[] */
    public static function ids(): array
    {
        if (auth()->check()) {
            return Favorite::where('user_id', auth()->id())->pluck('product_id')->all();
        }
        return array_map('intval', (array) session('favs', []));
    }

    public static function count(): int
    {
        return count(self::ids());
    }

    public static function has(int $productId): bool
    {
        return in_array($productId, self::ids(), true);
    }

    public static function toggle(int $productId): bool
    {
        if (!Product::whereKey($productId)->exists()) {
            return false;
        }
        if (auth()->check()) {
            $row = Favorite::where('user_id', auth()->id())->where('product_id', $productId)->first();
            if ($row) {
                $row->delete();
                return false;
            }
            Favorite::create(['user_id' => auth()->id(), 'product_id' => $productId]);
            return true;
        }
        $ids = self::ids();
        if (in_array($productId, $ids, true)) {
            $ids = array_values(array_diff($ids, [$productId]));
            session(['favs' => $ids]);
            return false;
        }
        $ids[] = $productId;
        session(['favs' => $ids]);
        return true;
    }

    /** Merge guest session favorites into the user's DB rows (after login/register). */
    public static function mergeFor(int $userId): void
    {
        $guest = array_map('intval', (array) session('favs', []));
        foreach ($guest as $pid) {
            Favorite::firstOrCreate(['user_id' => $userId, 'product_id' => $pid]);
        }
        session()->forget('favs');
    }

    /** @return \Illuminate\Support\Collection<Product> */
    public static function products()
    {
        return Product::with('category')->whereIn('id', self::ids())->get();
    }
}
