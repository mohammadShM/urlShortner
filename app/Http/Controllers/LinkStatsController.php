<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Laravel\Lumen\Http\ResponseFactory;

class LinkStatsController extends Controller
{

    public function show(Request $request): Response|JsonResponse|ResponseFactory
    {
        $code = $request->get('code');
        $link = Cache::remember("link.{$code}",10, static function () use ($code) {
            return Link::byCode($code)->first();
        });
        if ($link === null) {
            return response(null, 404);
        }
        return $this->linksResponse($link,[
                   'used_count' => $link->used_count,
                   'requested_count' => $link->requested_count,
        ]);
    }

}
