<?php

use function Pest\Laravel\getJson;

const EXPECTED_CONTENT = ['status' => 'Shorty is up and running!'];

it('should return some content', function () {
    getJson('/api')
        ->assertJson(EXPECTED_CONTENT)
        ->assertStatus(200);
});
