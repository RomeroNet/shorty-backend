<?php

namespace App\Infrastructure\Repository\Url;

use App\Domain\Url\Url;
use App\Domain\Url\UrlNotFoundException;
use App\Domain\Url\UrlRepository;
use App\Infrastructure\Model\Url as Model;
use Illuminate\Database\Eloquent\Builder;

readonly class EloquentUrlRepository implements UrlRepository
{
    public function __construct(
        private Model $model
    ) {}

    /**
     * @throws UrlNotFoundException
     */
    public function findByOrigin(string $origin): Url
    {
        /** @var Builder $query */
        $query = $this->model::whereOrigin($origin);

        /** @var Model|null $model */
        $model = $query->first();

        $url = $model?->toDomainEntity();

        if (!$url instanceof Url) {
            throw new UrlNotFoundException(sprintf('Url with origin %s not found', $origin));
        }

        return $url;
    }

    public function save(Url $url): void
    {
        $existing = $this->model::find($url->uuid);

        if ($existing) {
            $existing->fillFromDomainEntity($url)
                ->save();
            return;
        }

        $this->model::create($url->toArray());
    }
}
