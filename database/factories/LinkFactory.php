<?php

namespace Database\Factories;

use App\Models\Link;
use Illuminate\Database\Eloquent\Factories\Factory;

class LinkFactory extends Factory
{

    protected $model = Link::class;

    /** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
    public function definition(): array
    {
        return [
            'original_url' => $this->faker->url,
        ];
    }
}
