<?php

use App\Infrastructure\Model\Url as ModelUrl;

it('should return content from get', function (
    int $statusCode,
) {
    $url = ModelUrl::factory()->make();
    $url->save();

    if ($statusCode === 404) {
        $url->delete();
    }

    $parameter = $statusCode === 400
        ? ''
        : '?origin=' . $url->origin;

    $data = $this->get('/url' . $parameter);

    $data->assertStatus($statusCode);

    if ($statusCode === 200) {
        $url->visit_count++;
        $data->assertContent($url->toJson());
    }

})->with('UrlController');

dataset('UrlController', [
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
