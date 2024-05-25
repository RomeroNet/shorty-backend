<?php

namespace App\Domain\Url;

interface UrlRepository
{
    /**
     * @throws UrlNotFoundException
     */
    public function findByOrigin(string $origin): Url;
    public function save(Url $url): void;
}
