<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class Index extends Controller
{
    public function get(): JsonResponse
    {
        return response()->json(['status' => 'RomeroNet Boilerplate :)']);
    }
}
