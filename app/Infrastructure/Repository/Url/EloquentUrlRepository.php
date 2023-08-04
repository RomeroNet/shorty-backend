<?php

namespace App\Infrastructure\Repository\Url;

use App\Domain\Url\Url;
use App\Domain\Url\UrlNotFoundException;
use App\Domain\Url\UrlRepository;
use App\Infrastructure\Model\Url as Model;

readonly class EloquentUrlRepository implements UrlRepository
{
    public function __construct(
        private Model $model
    ) {}

    public function findByOrigin(string $origin): Url
    {
        $url = $this->model
            ::whereOrigin($origin)
            ->first()
            ?->toDomainEntity();

        if (!$url instanceof Url) {
            throw new UrlNotFoundException();
        }

        return $url;
    }

    public function save(Url $url): void
    {
        $this->model::find($url->uuid)
            ?->fillFromDomainEntity($url)
            ?->save();
    }
}
