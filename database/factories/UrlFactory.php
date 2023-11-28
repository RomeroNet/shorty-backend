<?php

namespace Database\Factories;

use App\Infrastructure\Model\Url;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class UrlFactory extends Factory
{
    protected $model = Url::class;

    public function definition(): array
    {
        return [
            'uuid' => fake()->uuid(),
            'origin' => fake()->asciify('*****'),
            'destination' => fake()->url(),
            'visit_count' => fake()->numberBetween(0, 100),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
