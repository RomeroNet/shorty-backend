<?php

namespace App\Infrastructure\Providers;

use App\Domain\Url\UrlRepository;
use App\Infrastructure\Repository\Url\EloquentUrlRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UrlRepository::class,
            EloquentUrlRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}
