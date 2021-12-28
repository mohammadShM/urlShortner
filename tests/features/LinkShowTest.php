<?php

namespace features;

use App\Models\Link;
use Laravel\Lumen\Testing\DatabaseTransactions;
use TestCase;

class LinkShowTest extends TestCase
{

    use DatabaseTransactions;

    public function test_requested_link_details_are_returned(): void
    {
        $link = Link::factory()->create([
            'code' => 'abc'
        ]);
        $this->json('Get', '/', [
            'code' => $link->code,
        ])->seeJson([
            'original_url' => $link->original_url,
            'shortened_url' => $link->shortenedUrl(),
            'code' => $link->code,
        ])->assertResponseOk();
    }

    public function test_throws_404_if_no_link_is_found(): void
    {
        $this->json('GET', '/', [
            'code' => '',
        ]);
        $this->assertResponseStatus(404);
    }

}
