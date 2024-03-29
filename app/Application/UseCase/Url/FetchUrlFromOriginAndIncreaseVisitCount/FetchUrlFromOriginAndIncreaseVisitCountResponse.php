<?php

namespace App\Application\UseCase\Url\FetchUrlFromOriginAndIncreaseVisitCount;

use App\Domain\Url\Url;
use Throwable;

readonly class FetchUrlFromOriginAndIncreaseVisitCountResponse
{
    public function __construct(
        public ?Url $url = null,
        public ?Throwable $error = null
    ) {}
}
