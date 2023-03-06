<?php

namespace Database\Factories;

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'post_title' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'post_content' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'user_id' => 1,
        ];
    }
}
