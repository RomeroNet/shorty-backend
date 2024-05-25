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

    $data = $this->get('/api/url' . $parameter);

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

})->with('url controller get');

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

    $data = $this->post('/api/url', $parameters);

    if ($statusCode === 409) {
        $data = $this->post('/api/url', $parameters);
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
})->with('url controller post');

it('should fail creating an URL with an invalid origin', function () {
    $faker = Faker\Factory::create();
    $parameters = [
        'origin' => $faker->asciify('*****'),
        'destination' => 'invaliddestination.com',
    ];

    $data = $this->post('/api/url', $parameters);

    $data->assertStatus(400);
    $data->assertJson([
        'error' => 'Destination is invalid',
    ]);
});

dataset('url controller get', [
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

dataset('url controller post', [
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
