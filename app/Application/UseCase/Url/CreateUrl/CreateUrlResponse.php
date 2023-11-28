<?php

namespace App\Application\UseCase\Url\CreateUrl;

use App\Domain\Url\Url;
use Throwable;

readonly class CreateUrlResponse
{
    public function __construct(
        public ?Url $url = null,
        public ?Throwable $error = null
    ) {}
}
