<?php

namespace middleware;

use App\Http\Middleware\Cors;
use Illuminate\Http\Response;
use Laravel\Lumen\Http\Request;
use TestCase;

class CorsMiddlewareTest extends TestCase
{

    public function test_preflight_request_is_handled(): void
    {
        $request = Request::create('/', 'OPTIONS');
        $middleware = new Cors();
        $response = new Response();
        $response = $middleware->handle($request, static function () use ($response) {

        });
        $this->assertEquals('*', $response->headers->get('Access-Control-Allow-Origin'));
        $this->assertEquals('HEAD,GET,POST,PUT,PATCH,DELETE,OPTIONS',
            $response->headers->get('Access-Control-Allow-Methods'));
        $this->assertEquals('Content-Type', $response->headers->get('Access-Control-Allow-Headers'));
        $this->assertEquals(200,$response->getStatusCode());
    }

    public function test_correct_headers_are_set(): void
    {
        $request = Request::create('/', 'POST');
        $middleware = new Cors();
        $response = new Response();
        $response = $middleware->handle($request, static function () use ($response) {
            return $response;
        });
        $this->assertEquals('*', $response->headers->get('Access-Control-Allow-Origin'));
        $this->assertEquals('HEAD,GET,POST,PUT,PATCH,DELETE,OPTIONS',
            $response->headers->get('Access-Control-Allow-Methods'));
        $this->assertEquals('Content-Type', $response->headers->get('Access-Control-Allow-Headers'));
    }

}
