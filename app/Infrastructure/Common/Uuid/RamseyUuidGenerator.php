<?php

namespace App\Infrastructure\Common\Uuid;

use App\Domain\Common\Uuid\UuidGeneratorInterface;
use Ramsey\Uuid\Uuid as RamseyUuid;

readonly class RamseyUuidGenerator implements UuidGeneratorInterface
{
    public function generate(): string
    {
        return RamseyUuid::uuid4()->toString();
    }
}
