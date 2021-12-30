<?php

namespace features;

use App\Models\Link;
use Laravel\Lumen\Testing\DatabaseTransactions;
use TestCase;

class LinkStatsTest extends TestCase
{

    use DatabaseTransactions;

    public function test_stats_can_be_shown_by_shortened_code(): void
    {
        $link = Link::factory()->create([
            'code' => 'abc',
            'requested_count' => 5,
            'used_count' => 234,
        ]);
        $this->json('GET', '/stats', ['code' => $link->code])
            ->seeJson($this->expectedJson($link));
    }

    public function test_link_stats_fails_if_not_found(): void
    {
        $this->json('GET', '/stats', ['code' => "abc"])
            ->assertResponseStatus(404);
    }

    // Util Method ====================================================================================
    /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
    private function expectedJson($link): array
    {
        return [
            'original_url' => $link->original_url,
            'shortened_url' => $link->shortenedUrl(),
            'code' => $link->code,
            'used_count' => $link->used_count,
            'requested_count' => $link->requested_count,
        ];
    }

}
