<?php

namespace features;

use App\Models\Link;
use Laravel\Lumen\Testing\DatabaseTransactions;
use TestCase;

class LinkCreationTest extends TestCase
{

    use DatabaseTransactions;

    public function test_fails_if_no_url_has_given(): void
    {
        $this->json('POST', '/')->notSeeInDatabase('links', [
            'code' => 1000000,
        ])->seeJson(['url' => ['Please enter a URL to shorten.']])
            ->assertResponseStatus(422);
    }

    public function test_fails_if_url_is_invalid(): void
    {
        $this->json('POST', '/', [
            // 'url'=>'http://example@$hg#fd$',
            'url' => 'http//://google@$hg#fd$',
        ])
            ->notSeeInDatabase('links', [
                'code' => 1000000,
            //])->seeJson(['url' => ['Ham, that is not a valid url.', 'The url is not a valid URL.']])
            ])->seeJson(['url' => ['The url is not a valid URL.']])
            ->assertResponseStatus(422);
    }

    public function test_link_can_be_shortened(): void
    {
        /** @noinspection LaravelFunctionsInspection */
        $this->json('POST', '/', [
            'url' => 'http://example.com',
            'code' => 1
        ])->seeInDatabase('links', [
            'original_url' => 'http://example.com',
            'code' => 1
        ])->seeJson([
            'data' => [
                'original_url' => 'http://example.com',
                'shortened_url' => env('CLIENT_URL') . '1',
                'code' => '1',
                 "0" => []
            ],
        ])->assertResponseStatus(200);
    }

    public function test_link_is_only_shortened_once(): void
    {
        $url = "http://www.google.com";
        $this->json('POST', '/', ['url' => $url]);
        $this->json('POST', '/', ['url' => $url]);
        $link = Link::query()->where(['original_url' => $url])->get();
        $this->assertCount(1, $link);
    }

    public function test_requested_count_is_incremented(): void
    {
        $url = "http://www.google.com";
        $this->json('POST', '/', ['url' => $url]);
        $this->json('POST', '/', ['url' => $url]);
        $this->seeInDatabase('links', [
            'original_url' => $url,
            'requested_count' => 2
        ]);
    }

}
