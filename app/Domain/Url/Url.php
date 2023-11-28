<?php

namespace App\Domain\Url;

use Carbon\Carbon;

readonly class Url
{
    public function __construct(
        public string $uuid,
        public string $origin,
        public string $destination,
        public int $visitCount,
        public ?Carbon $createdAt,
        public ?Carbon $updatedAt,
    ) {
    }

    public function increaseVisitCount(): self
    {
        return new self(
            $this->uuid,
            $this->origin,
            $this->destination,
            $this->visitCount + 1,
            $this->createdAt,
            $this->updatedAt,
        );
    }

    /**
     * @return array{uuid: string, origin: string, destination: string, visit_count: int, created_at: ?Carbon, updated_at: ?Carbon}
     */
    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'origin' => $this->origin,
            'destination' => $this->destination,
            'visit_count' => $this->visitCount,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
