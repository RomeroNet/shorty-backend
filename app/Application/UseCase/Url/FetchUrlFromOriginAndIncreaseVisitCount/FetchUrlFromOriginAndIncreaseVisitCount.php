<?php

namespace App\Application\UseCase\Url\FetchUrlFromOriginAndIncreaseVisitCount;

use App\Domain\Url\FetchUrlFromOrigin;
use App\Domain\Url\IncreaseVisitCount;
use InvalidArgumentException;
use Throwable;

readonly class FetchUrlFromOriginAndIncreaseVisitCount
{
    public function __construct(
        private FetchUrlFromOrigin $fetchUrlFromOrigin,
        private IncreaseVisitCount $increaseVisitCount,
    ) {}

    public function handle(mixed $origin): FetchUrlFromOriginAndIncreaseVisitCountResponse
    {
        try {
            if (empty($origin) || !is_string($origin)) {
                throw new InvalidArgumentException('Origin is required');
            }

            $url = $this->fetchUrlFromOrigin->fetch($origin);
            $url = $this->increaseVisitCount->increase($url);

            return new FetchUrlFromOriginAndIncreaseVisitCountResponse($url);

        } catch (Throwable $e) {
            return new FetchUrlFromOriginAndIncreaseVisitCountResponse(error: $e);
        }
    }
}
