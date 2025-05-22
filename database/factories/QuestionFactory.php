<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => rtrim($this->faker->sentence(rand(5, 10)), '.'),
            'body' => $this->faker->paragraphs(rand(3, 7), true),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'view_count' => $this->faker->numberBetween(0, 10000),
            'vote_count' => $this->faker->numberBetween(-10, 100),
            'is_closed' => $this->faker->boolean(10), // 10% cơ hội là true
            'closed_at' => $this->faker->optional(0.1)->dateTimeBetween('-1 year', 'now'), // 10% có giá trị
            'closed_reason' => $this->faker->optional(0.1)->randomElement([
                'Duplicate question',
                'Off-topic',
                'Too broad',
                'Opinion-based'
            ]),
        ];
    }
}
