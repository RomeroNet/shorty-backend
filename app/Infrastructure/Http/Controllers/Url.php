<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\UseCase\Url\FetchUrlFromOriginAndIncreaseVisitCount\FetchUrlFromOriginAndIncreaseVisitCount;
use App\Domain\Url\UrlNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\ResponseFactory;

class Url extends Controller
{
    public function __construct(
        private readonly FetchUrlFromOriginAndIncreaseVisitCount $fetchUrl,
        private readonly ResponseFactory $responseFactory,
    ) {}

    public function get(Request $request): JsonResponse
    {
        $origin = $request->input('origin');

        $response = $this->fetchUrl->handle($origin);

        if ($response->error) {
            return $this->handleError($response->error);
        }

        return $this->responseFactory->json($response->url?->toArray() ?? []);
    }

    public function handleError(\Throwable $error): JsonResponse
    {
        $code = 500;

        if ($error instanceof UrlNotFoundException) {
            $code = 404;
        }

        if ($error instanceof \InvalidArgumentException) {
            $code = 400;
        }

        return $this->responseFactory->json([
            'error' => $error->getMessage(),
        ], $code);
    }
}
