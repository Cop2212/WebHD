<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerFactory extends Factory
{
    protected $model = Answer::class;

    // database/factories/AnswerFactory.php
public function definition()
{
    return [
        'question_id' => Question::factory(),
        'user_id' => User::factory(),
        'body' => $this->faker->paragraphs(rand(1, 5), true),
        'is_accepted' => $this->faker->boolean(20),
        'vote_count' => $this->faker->numberBetween(-5, 50),
    ];
}
}
