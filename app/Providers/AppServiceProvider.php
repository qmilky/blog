<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Vendor\Sequence;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('ArticleCateService', function ($app) {
            return new ArticleCateService($app);
        });
        $this->app->singleton('sequence', function ($app) {
            return new Sequence(1);
        });

    }
}
