<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\UseCase\Url\FetchUrlFromOriginAndIncreaseVisitCount\FetchUrlFromOriginAndIncreaseVisitCount;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class Url extends Controller
{
    public function __construct(
        private readonly FetchUrlFromOriginAndIncreaseVisitCount $fetchUrl
    ) {}

    public function get(Request $request): JsonResponse
    {
        $origin = $request->input('origin');
        $response = $this->fetchUrl->handle($origin);
        return response()->json($response->url->toArray());
    }
}
