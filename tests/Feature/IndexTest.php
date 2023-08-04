<?php

use function Pest\Laravel\getJson;

const EXPECTED_CONTENT = ['status' => 'Shorty is up and running!'];

it('should return some content', function () {
    getJson('/')->assertContent(json_encode(EXPECTED_CONTENT))
        ->assertStatus(200);
});
