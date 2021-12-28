<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Http\ResponseFactory;

class LinkController extends Controller
{

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
            // update for LinkObserver ======================================
//            $link->update([
//                'code' => $link->getCode(),
//            ]);
        }
        // increment Instead requested_count++ ======================================
        $link->increment('requested_count');
        return $this->linksResponse($link);
    }

    public function show(Request $request): Response|JsonResponse|ResponseFactory
    {
        $code = $request->get('code');
        $link = Link::byCode($code)->first();
        if ($link === null) {
            return response(null, 404);
        }
        return $this->linksResponse($link);
    }

}
