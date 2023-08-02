<?php

namespace App\Infrastructure\Repository\Url;

use App\Domain\Url\Url;
use App\Domain\Url\UrlRepository;
use App\Infrastructure\Model\Url as Model;

readonly class EloquentUrlRepository implements UrlRepository
{
    public function __construct(
        private Model $model
    ) {}

    public function findByOrigin(string $origin): ?Url
    {
        return $this->model
            ::whereOrigin($origin)
            ->first()
            ?->toDomainEntity();
    }

    public function save(Url $url): void
    {
        $this->model::find($url->uuid)
            ?->fillFromDomainEntity($url)
            ?->save();
    }
}
