<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // ?lang=fa|en makes language URLs crawlable (SEO); session keeps the choice
        $q = $request->query('lang');
        if (in_array($q, ['fa', 'en'], true)) {
            session(['lang' => $q]);
        }
        app()->setLocale(session('lang', 'fa'));
        return $next($request);
    }
}
