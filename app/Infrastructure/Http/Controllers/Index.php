<?php

namespace App\Infrastructure\Http\Controllers;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class Index extends Controller
{
    public function __construct(private readonly ResponseFactory $responseFactory)
    {}

    public function get(): JsonResponse
    {
        return $this->responseFactory->json([
            'status' => 'Shorty is up and running!',
        ]);
    }
}
