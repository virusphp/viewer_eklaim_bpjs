<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Views\Composers\SearchComposer;

class SearchProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        view()->composer('layouts.search.search', SearchComposer::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
