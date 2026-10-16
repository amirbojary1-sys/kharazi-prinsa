<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Blade::directive('price', fn ($e) => "<?php echo \\App\\Support\\Fmt::price($e); ?>");
        Blade::directive('num', fn ($e) => "<?php echo \\App\\Support\\Fmt::num($e); ?>");
        Blade::directive('fdate', fn ($e) => "<?php echo \\App\\Support\\Fmt::date($e); ?>");

        // share mega-menu data with the layout everywhere
        View::composer('layouts.app', function ($view) {
            $view->with('megaCategories', \App\Models\Category::with('subcategories')->withCount('products')->get());
        });
    }
}
