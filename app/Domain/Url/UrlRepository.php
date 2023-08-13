<?php

namespace App\Domain\Url;

interface UrlRepository
{
    public function findByOrigin(string $origin): Url;
    public function save(Url $url): void;
}
