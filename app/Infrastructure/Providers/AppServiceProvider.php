<?php

namespace App\Infrastructure\Providers;

use App\Domain\Url\UrlRepository;
use App\Infrastructure\Repository\Url\EloquentUrlRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            UrlRepository::class,
            EloquentUrlRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
