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
        $link = Cache::remember("link.{$code}", 10, static function () use ($code) {
            return Link::byCode($code)->first();
        });
        if ($link === null) {
            return response(null, 404);
        }
        return $this->linksResponse($link, [
            'requested_count' => $link->requested_count,
            'used_count' => $link->used_count,
            'last_requested' => $link->last_requested->toDateTimeString(),
            // 'last_used' => $link->last_used ? $link->last_used->toDateTimeString() : null,
            'last_used' => $link->last_used?->toDateTimeString(),
        ]);
    }

}
