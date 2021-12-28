<?php

namespace middleware;

use App\Http\Middleware\ModifiesUrlRequestData;
use Laravel\Lumen\Http\Request;
use TestCase;

class UrlMiddlewareTest extends TestCase
{

    public function test_http_is_prepended_to_url(): void
    {
        $request = new Request();
        $request->replace([
            'url' => 'google.com'
        ]);
        $middleware = new ModifiesUrlRequestData();
        $middleware->handle($request, function ($req) {
            $this->assertEquals('http://google.com', $req->url);
        });
    }

}
