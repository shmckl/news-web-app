<?php

namespace Database\Factories;

use Faker\Generator as Faker;
use Illuminate\Support\Str;
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
        $title = $this->faker->regexify('[A-Za-z0-9]{10}');
        return [
            'post_title' => $title,
            'slug' => Str::slug($title),
            'post_content' => $this->faker->paragraph,
            'user_id' => random_int(1,10),
        ];
        //dont hard code numbers, instead:
        // 'author_id' => fake()->numberBetween(1, \App\Models\User::count())
    }
}
