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
            'error' => $errorMessage,
        ]);
    }

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
