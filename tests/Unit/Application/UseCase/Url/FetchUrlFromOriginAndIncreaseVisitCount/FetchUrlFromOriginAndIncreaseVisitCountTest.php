<?php

use App\Application\UseCase\Url\FetchUrlFromOriginAndIncreaseVisitCount\FetchUrlFromOriginAndIncreaseVisitCount;
use App\Domain\Url\FetchUrlFromOrigin;
use App\Domain\Url\IncreaseVisitCount;
use App\Domain\Url\Url;
use App\Domain\Url\UrlNotFoundException;
use App\Domain\Url\UrlRepository;
use Carbon\Carbon;

beforeEach(function () {
    Mockery::close();
});

it('should fetch an URL from origin and increase visit count', function (
    bool $originIsEmpty,
    bool $repositoryReturnsUrl,
    bool $repositoryIncrementsVisitCount,
    ?string $error
) {
    $faker = Faker\Factory::create();
    $origin = $faker->url();
    $visitCount = $faker->numberBetween(1, 100);
    $url = new Url(
        uuid: $faker->uuid(),
        origin: $origin,
        destination: $faker->url(),
        visitCount: $visitCount,
        createdAt: Carbon::now(),
        updatedAt: Carbon::now(),
    );

    $repository = Mockery::mock(UrlRepository::class);

    if ($repositoryReturnsUrl) {
        $repository->shouldReceive('findByOrigin')
            ->with($origin)
            ->andReturn($url);
    } else {
        $repository->shouldReceive('findByOrigin')
            ->with($origin)
            ->andThrow(new UrlNotFoundException());
    }

    if ($repositoryIncrementsVisitCount) {
        $repository->shouldReceive('save')->once();
    }

    $fetchUrl = new FetchUrlFromOrigin($repository);
    $increaseVisitCount = new IncreaseVisitCount($repository);

    $service = new FetchUrlFromOriginAndIncreaseVisitCount(
        $fetchUrl,
        $increaseVisitCount,
    );
    $response = $service->handle(
        $originIsEmpty
            ? null
            : $origin
    );

    if ($error) {
        expect($response->error)->toBeInstanceOf($error);
        return;
    }

    expect($response->error)->toBeNull()
        ->and($response->url)
        ->toBeInstanceOf(Url::class)
        ->and($response->url?->visitCount)
        ->toBe($visitCount + 1);
})->with('fetch URL from origin and increase visit count');

dataset('fetch URL from origin and increase visit count', [
    'when repository returns an URL' => [
        'originIsEmpty' => false,
        'repositoryReturnsUrl' => true,
        'repositoryIncrementsVisitCount' => true,
        'error' => null,
    ],
    'when repository does not return an URL' => [
        'originIsEmpty' => false,
        'repositoryReturnsUrl' => false,
        'repositoryIncrementsVisitCount' => false,
        'error' => UrlNotFoundException::class,
    ],
    'when origin is empty' => [
        'originIsEmpty' => true,
        'repositoryReturnsUrl' => false,
        'repositoryIncrementsVisitCount' => false,
        'error' => InvalidArgumentException::class,
    ],
]);
