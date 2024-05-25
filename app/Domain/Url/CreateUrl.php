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

    /**
     * @throws InvalidUrlException
     */
    public function create(
        string $origin,
        string $destination
    ): Url {
        $this->validateDestination($destination);

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

    /**
     * @throws InvalidUrlException
     */
    private function validateDestination(string $destination): void
    {
        if (!filter_var($destination, FILTER_VALIDATE_URL)) {
            throw new InvalidUrlException('Destination is invalid');
        }
    }
}
