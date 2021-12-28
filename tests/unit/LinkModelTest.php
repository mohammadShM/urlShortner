<?php

namespace unit;

use App\Exceptions\CodeGenerationException;
use App\Models\Link;
use Laravel\Lumen\Testing\DatabaseTransactions;
use TestCase;

class LinkModelTest extends TestCase
{

    use DatabaseTransactions;

    protected array $mappings = [
        1 => 1,
        100 => '1C',
        10000 => '2Bi',
        11111 => '2Td',
    ];

    /**
     * @throws CodeGenerationException
     */
    public function test_correct_code_is_generated(): void
    {
        $link = new Link();
        foreach ($this->mappings as $id => $expectedCode) {
            $link->id = $id;
            $this->assertEquals($link->getCode(), $expectedCode);
        }
    }

    public function test_exception_is_throw_with_no_id(): void
    {
        // for error by throw exception when not id in method getCode in Link model
        $this->expectException(CodeGenerationException::class);
        $link = new Link();
        $link->getCode();
    }

    public function test_can_get_model_by_code(): void
    {
        $link = Link::factory()->create([
            'code' => 'abc',
        ]);
        $model = Link::byCode($link->code)->first();
        $this->assertInstanceOf(Link::class, $model);
        $this->assertEquals($model->original_url, $link->original_url);
    }

    public function test_can_get_shortened_url_from_link_model(): void
    {
        $link = Link::factory()->create([
            'code' => 'abc',
        ]);
        /** @noinspection LaravelFunctionsInspection */
        $this->assertEquals($link->shortenedUrl(),env('CLIENT_URL') .$link->code);
    }

    public function test_null_is_returned_for_shortened_url_when_no_code_is_present_on_model(): void
    {
        // for LinkObserver not use in test ===================
        Link::flushEventListeners();
        $link = Link::factory()->create([]);
        $this->assertNull($link->shortenedUrl());
    }

}
