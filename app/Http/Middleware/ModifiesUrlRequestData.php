<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ModifiesUrlRequestData
{

    public function handle(Request $request, Closure $next)
    {
        if (!$request->has('url')) {
            return $next($request);
        }
        $validator = Validator::make($request->only('url'),[
            'url' =>'active_url|url',
        ]);
        if ($validator->fails()) {
            $request->merge([
                'url' => 'http://'.$request->get('url'),
            ]);
        }
        return $next($request);
    }
}
