<?php

namespace App\Domain\Url;

readonly class FetchUrlFromOrigin
{
    public function __construct(private UrlRepository $urlRepository)
    {}

    public function fetch(string $origin): Url
    {
        return $this->urlRepository->findByOrigin($origin);
    }
}
