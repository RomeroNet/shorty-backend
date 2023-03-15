<?php

use function Pest\Laravel\getJson;

const EXPECTED_CONTENT = ['status' => 'RomeroNet Boilerplate :)'];

it('should return some content', function () {
    getJson('/')->assertContent(json_encode(EXPECTED_CONTENT))
        ->assertStatus(200);
});
