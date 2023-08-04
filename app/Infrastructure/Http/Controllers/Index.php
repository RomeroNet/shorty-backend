<?php

namespace App\Infrastructure\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class Index extends Controller
{
    public function get(): JsonResponse
    {
        return response()->json(['status' => 'Shorty is up and running!']);
    }
}
