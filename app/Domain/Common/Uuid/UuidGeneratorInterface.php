<?php

namespace App\Domain\Common\Uuid;

interface UuidGeneratorInterface
{
    public function generate(): string;
}
