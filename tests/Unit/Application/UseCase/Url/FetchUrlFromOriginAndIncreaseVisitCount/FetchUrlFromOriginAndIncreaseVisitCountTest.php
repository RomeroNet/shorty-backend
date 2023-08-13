<?php

use App\Application\UseCase\Url\FetchUrlFromOriginAndIncreaseVisitCount\FetchUrlFromOriginAndIncreaseVisitCount;
use App\Domain\Url\FetchUrlFromOrigin;
use App\Domain\Url\IncreaseVisitCount;
use App\Domain\Url\Url;
use App\Domain\Url\UrlNotFoundException;
use App\Domain\Url\UrlRepository;
use Carbon\Carbon;

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
        $this->assertInstanceOf($error, $response->error);
        return;
    }

    $this->assertEmpty($response->error);
    $this->assertInstanceOf(Url::class, $response->url);
    $this->assertSame($response->url?->visitCount, $visitCount + 1);
})->with('FetchUrlFromOriginAndIncreaseVisitCount');

dataset('FetchUrlFromOriginAndIncreaseVisitCount', [
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
