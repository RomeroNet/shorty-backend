<?php

use App\Infrastructure\Model\Url as ModelUrl;

it('should return content from get', function (
    int $statusCode,
) {
    $url = ModelUrl::factory()->make();
    $url->save();
    $parameter = '?origin=' . $url->origin;

    if ($statusCode === 404) {
        $errorMessage = sprintf('Url with origin %s not found', $url->origin);
        $url->delete();
    }

    if ($statusCode === 400) {
        $errorMessage = 'Origin is required';
        $parameter = '';
    }

    $data = $this->get('/url' . $parameter);

    $data->assertStatus($statusCode);

    if ($statusCode !== 200) {
        $data->assertJson([
            'error' => $errorMessage ?? '',
        ]);
    }

    if ($statusCode === 200) {
        $url->visit_count++;
        $data->assertContent($url->toJson());
    }

})->with('UrlControllerGet');

it('should create a URL from post', function (
    int $statusCode,
    bool $originIsEmpty = false,
    bool $destinationIsEmpty = false,
) {
    $faker = Faker\Factory::create();
    $parameters = [
        'origin' => $originIsEmpty ? null : $faker->asciify('*****'),
        'destination' => $destinationIsEmpty ? null : $faker->url(),
    ];

    $data = $this->post('/url', $parameters);

    if ($statusCode === 409) {
        $data = $this->post('/url', $parameters);
    }

    $data->assertStatus($statusCode);

    if ($statusCode === 409) {
        $data->assertJson([
            'error' => 'Origin already exists',
        ]);
        return;
    }
    if ($originIsEmpty) {
        $data->assertJson([
            'error' => 'Origin is required',
        ]);
        return;
    }
    if ($destinationIsEmpty) {
        $data->assertJson([
            'error' => 'Destination is required',
        ]);
        return;
    }

    $data->assertJson([
        'origin' => $parameters['origin'],
        'destination' => $parameters['destination'],
        'visit_count' => 0,
    ]);
})->with('UrlControllerPost');

dataset('UrlControllerGet', [
    'when the url is found' => [
        'statusCode' => 200,
    ],
    'when the url is not found' => [
        'statusCode' => 404,
    ],
    'when no origin is provided' => [
        'statusCode' => 400,
    ],
]);

dataset('UrlControllerPost', [
    'when the url is created' => [
        'statusCode' => 200,
    ],
    'when no origin is provided' => [
        'statusCode' => 400,
        'originIsEmpty' => true,
    ],
    'when no destination is provided' => [
        'statusCode' => 400,
        'originIsEmpty' => false,
        'destinationIsEmpty' => true,
    ],
    'when the origin is duplicated' => [
        'statusCode' => 409,
    ],
]);
