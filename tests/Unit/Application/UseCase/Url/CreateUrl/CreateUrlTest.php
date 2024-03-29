<?php

use App\Application\UseCase\Url\CreateUrl\CreateUrl;
use App\Domain\Common\Uuid\UuidGeneratorInterface;
use App\Domain\Url\CreateUrl as CreateUrlDomain;
use App\Domain\Url\DuplicatedOriginException;
use App\Domain\Url\FetchUrlFromOrigin;
use App\Domain\Url\Url;
use App\Domain\Url\UrlNotFoundException;
use App\Domain\Url\UrlRepository;

beforeEach(function () {
    Mockery::close();
});

it('should create an URL from input', function (
    bool $hasOrigin,
    bool $hasDestination,
    bool $repositoryReturnsUrl,
    ?string $error
) {
    $faker = Faker\Factory::create();
    $origin = $hasOrigin ? $faker->asciify('*****') : null;
    $destination = $hasDestination ? $faker->url() : null;

    $urlRepository = Mockery::mock(UrlRepository::class);

    if ($repositoryReturnsUrl) {
        $url = new Url(
            $faker->uuid(),
            $origin ?? '',
            $destination ?? '',
            0,
            null,
            null,
        );
        $urlRepository->shouldReceive('findByOrigin')
            ->with($origin)
            ->andReturn($url);
    } else {
        $urlRepository->shouldReceive('findByOrigin')
            ->with($origin)
            ->andThrow(new UrlNotFoundException());
        if ($hasOrigin && $hasDestination) {
            $urlRepository->shouldReceive('save')->once();
        }
    }

    $uuidGenerator = Mockery::mock(UuidGeneratorInterface::class);
    $uuidGenerator->shouldReceive('generate')->andReturn($faker->uuid());

    $fetchUrl = new FetchUrlFromOrigin($urlRepository);
    $createUrl = new CreateUrlDomain($urlRepository, $uuidGenerator);

    $service = new CreateUrl(
        $fetchUrl,
        $createUrl
    );

    $response = $service->handle($origin, $destination);

    if ($error) {
        expect($response->error)->toBeInstanceOf($error);
        return;
    }

    expect($response->error)->toBeNull()
        ->and($response->url)
        ->toBeInstanceOf(Url::class)
        ->and($response->url?->origin)
        ->toBe($origin)
        ->and($response->url?->destination)
        ->toBe($destination);
})->with('CreateUrl');

dataset('CreateUrl', [
    'when origin and destination are not empty' => [
        'hasOrigin' => true,
        'hasDestination' => true,
        'repositoryReturnsUrl' => false,
        'error' => null,
    ],
    'when origin is empty' => [
        'hasOrigin' => false,
        'hasDestination' => true,
        'repositoryReturnsUrl' => false,
        'error' => InvalidArgumentException::class,
    ],
    'when destination is empty' => [
        'hasOrigin' => true,
        'hasDestination' => false,
        'repositoryReturnsUrl' => false,
        'error' => InvalidArgumentException::class,
    ],
    'when origin is duplicated' => [
        'hasOrigin' => true,
        'hasDestination' => true,
        'repositoryReturnsUrl' => true,
        'error' => DuplicatedOriginException::class,
    ],
]);

