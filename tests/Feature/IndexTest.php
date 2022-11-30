<?php

namespace Tests\Feature;

use Tests\TestCase;

class IndexTest extends TestCase
{
    private const EXPECTED_CONTENT = ['status' => 'RomeroNet Boilerplate :)'];

    /**
     * @test
     */
    public function indexShouldWork(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertContent(json_encode(self::EXPECTED_CONTENT));
    }
}
