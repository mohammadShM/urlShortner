<?php

namespace features;

use App\Models\Link;
use Illuminate\Support\Carbon;
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
            'last_requested' => Carbon::now(),
        ]);
        $this->json('GET', '/stats', ['code' => $link->code])
            ->seeJson($this->expectedJson($link));
    }

    public function test_link_stats_fails_if_not_found(): void
    {
        $this->json('GET', '/stats', ['code' => "abc"])
            ->assertResponseStatus(404);
    }

    public function test_last_requested_date_is_updated_for_existing_links(): void
    {
        Link::flushEventListeners();
        $link = Link::factory()->create([
            'last_requested' => Carbon::now()->subDays(2),
        ]);
        $this->json('POST', '/',
            ['url' => $link->original_url])
        ->seeInDatabase('links',[
            'original_url' =>$link->original_url,
            'last_requested' => Carbon::now()->toDateTimeString(),
        ]);
    }

    public function test_last_used_is_updated(): void
    {
        Link::flushEventListeners();
        $link = Link::factory()->create([
            'last_used' => Carbon::now()->subDays(2),
        ]);
        $this->json('GET', '/',
            ['code' => $link->code])
            ->seeInDatabase('links',[
                'original_url' =>$link->original_url,
                'last_used' => Carbon::now()->toDateTimeString(),
            ]);
    }

    // Util Method ====================================================================================

    /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
    private function expectedJson($link): array
    {
        return [
            'original_url' => $link->original_url,
            'shortened_url' => $link->shortenedUrl(),
            'code' => $link->code,
            'requested_count' => $link->requested_count,
            'used_count' => $link->used_count,
            'last_requested' => $link->last_requested->toDateTimeString(),
            // 'last_used' => $link->last_used ? $link->last_used->toDateTimeString() : null,
            'last_used' => $link->last_used?->toDateTimeString(),
        ];
    }

}
