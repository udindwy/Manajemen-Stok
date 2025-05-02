<?php

namespace App\Providers;

use App\Models\Produk;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('layouts.sidebar', function ($view) {
            $stokMinimCount = Produk::stokMinim()->count();
            $view->with('stokMinimCount', $stokMinimCount);
        });
    }
}
