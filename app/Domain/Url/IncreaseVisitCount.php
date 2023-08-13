<?php

namespace App\Domain\Url;

readonly class IncreaseVisitCount
{
    public function __construct(private UrlRepository $urlRepository)
    {}

    public function increase(Url $url): Url
    {
        $newUrl = $url->increaseVisitCount();
        $this->urlRepository->save($newUrl);
        return $newUrl;
    }
}
