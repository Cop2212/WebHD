<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'body' => $this->faker->paragraphs(3, true),
            'user_id' => User::factory(),
            'views' => $this->faker->numberBetween(0, 1000),
            'votes_count' => $this->faker->numberBetween(0, 50)
        ];
    }
}
