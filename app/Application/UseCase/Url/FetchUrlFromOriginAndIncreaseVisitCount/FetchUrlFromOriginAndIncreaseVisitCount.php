<?php

namespace App\Application\UseCase\Url\FetchUrlFromOriginAndIncreaseVisitCount;

use App\Domain\Url\Url;
use App\Domain\Url\UrlRepository;

readonly class FetchUrlFromOriginAndIncreaseVisitCount
{
    public function __construct(
        private UrlRepository $urlRepository,
    ) {}

    public function handle(?string $origin): FetchUrlFromOriginAndIncreaseVisitCountResponse
    {
        if (empty($origin)) {
            throw new \Exception();
        }

        $url = $this->urlRepository->findByOrigin($origin);

        if (!$url instanceof Url) {
            throw new \Exception();
        }

        $this->urlRepository->save($url->increaseVisitCount());

        return new FetchUrlFromOriginAndIncreaseVisitCountResponse($url);
    }
}
