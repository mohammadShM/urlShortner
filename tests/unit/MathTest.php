<?php

namespace unit;

use App\Helpers\Math;
use TestCase;

class MathTest extends TestCase
{

    protected array $mappings = [
        1 => 1,
        100 => '1C',
        10000 => '2Bi',
        11111 => '2Td',
    ];

    public function test_correctly_encodes_values(): void
    {
        foreach ($this->mappings as $value => $encoded) {
            // var_dump(Math::to_base(11111));
            $this->assertEquals($encoded, Math::to_base($value));
        }
    }

    public function test_error_correctly_encodes_values(): void
    {
        foreach ($this->mappings as $value => $encoded) {
            $i = 2000;
            $i++;
            $this->assertNotEquals($i, Math::to_base($value));
        }
    }

}
