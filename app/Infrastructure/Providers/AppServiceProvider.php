<?php

namespace App\Infrastructure\Providers;

use App\Domain\Common\Uuid\UuidGeneratorInterface;
use App\Domain\Url\UrlRepository;
use App\Infrastructure\Common\Uuid\RamseyUuidGenerator;
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
        $this->app->bind(
            UuidGeneratorInterface::class,
            RamseyUuidGenerator::class
        );
    }

    public function boot(): void
    {
        //
    }
}
