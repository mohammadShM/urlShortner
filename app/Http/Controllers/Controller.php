<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\JsonResponse;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{

    protected function linksResponse(Link $link,$merge=[]): JsonResponse
    {
        /** @noinspection LaravelFunctionsInspection */
        return response()->json([
            'data' => [
                'original_url' => $link->original_url,
                'shortened_url' => env('CLIENT_URL') . $link->code,
                'code' => $link->code,
                $merge,
            ],
        ]);
    }

}
