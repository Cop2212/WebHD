<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerFactory extends Factory
{
    protected $model = Answer::class;

    public function definition()
{
    return [
        'body' => $this->faker->paragraphs(3, true),
        'question_id' => Question::factory(),
        'user_id' => User::factory(),
        'is_accepted' => false,
        'votes_count' => 0
    ];
}
}
