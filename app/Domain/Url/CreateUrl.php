<?php

namespace App\Domain\Url;

use App\Domain\Common\Uuid\UuidGeneratorInterface;
use Carbon\Carbon;

readonly class CreateUrl
{
    public function __construct(
        private UrlRepository $urlRepository,
        private UuidGeneratorInterface $uuidGenerator,
    ) {}

    public function create(
        string $origin,
        string $destination
    ): Url {
        $url = new Url(
            $this->uuidGenerator->generate(),
            $origin,
            $destination,
            0,
            Carbon::now(),
            Carbon::now(),
        );

        $this->urlRepository->save($url);

        return $url;
    }
}
