<?php

namespace App\Application\UseCase\Url\CreateUrl;

use App\Domain\Url\CreateUrl as CreateUrlService;
use App\Domain\Url\DuplicatedOriginException;
use App\Domain\Url\FetchUrlFromOrigin;
use App\Domain\Url\UrlNotFoundException;
use InvalidArgumentException;
use Throwable;

readonly class CreateUrl
{
    public function __construct(
        private FetchUrlFromOrigin $fetchUrlFromOrigin,
        private CreateUrlService $createUrlService,
    ) {}

    public function handle(
        string $origin,
        string $destination
    ): CreateUrlResponse {
        try {
            $this->validateInput($origin, $destination);

            try {
                $this->fetchUrlFromOrigin->fetch($origin);
                throw new DuplicatedOriginException('Origin already exists');
            } catch (UrlNotFoundException) {
            }

            $url = $this->createUrlService->create($origin, $destination);
            return new CreateUrlResponse($url);
        } catch (Throwable $e) {
            return new CreateUrlResponse(error: $e);
        }
    }

    private function validateInput(mixed $origin, mixed $destination): void
    {
        if (empty($origin)) {
            throw new InvalidArgumentException('Origin is required');
        }
        if (empty($destination)) {
            throw new InvalidArgumentException('Destination is required');
        }
    }
}
