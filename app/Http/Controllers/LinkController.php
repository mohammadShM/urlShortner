<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Laravel\Lumen\Http\ResponseFactory;

class LinkController extends Controller
{

    public function show(Request $request): Response|JsonResponse|ResponseFactory
    {
        $code = $request->get('code');
        $link = Cache::rememberForever("link.$code", static function () use ($code) {
            return Link::byCode($code)->first();
        });
        if ($link === null) {
            return response(null, 404);
        }
        $link->increment('used_count');
        $link->touchTimeStamp('last_used');
        return $this->linksResponse($link);
    }

    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'url' => 'required|active_url|url',
        ], [
            'url.required' => 'Please enter a URL to shorten.',
            'url.url' => 'Ham, that is not a valid url.',
            'url.active_url' => 'The url is not a valid URL.',
        ]);
        $link = Link::firstOrNew([
            'original_url' => $request->get('url'),
        ]);
        if (!$link->exists) {
            $link->save();
        }
        // increment Instead requested_count++ ======================================
        $link->increment('requested_count');
        $link->update([
            'code' => $link->getCode(),
            'last_requested' => Carbon::now(),
        ]);
        $link->touchTimeStamp('last_requested');
        return $this->linksResponse($link);
    }

}
