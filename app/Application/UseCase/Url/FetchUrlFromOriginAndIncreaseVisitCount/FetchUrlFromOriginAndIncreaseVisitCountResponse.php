<?php

namespace App\Application\UseCase\Url\FetchUrlFromOriginAndIncreaseVisitCount;

use App\Domain\Url\Url;

readonly class FetchUrlFromOriginAndIncreaseVisitCountResponse
{
    public function __construct(
        public Url $url,
    ) {}
}
