<?php

namespace Database\Factories;

use Gamify\Models\QuestionChoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionChoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuestionChoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'text' => $this->faker->sentence,
            'score' => $this->faker->numberBetween(1, 10),
        ];
    }

    /**
     * Indicate that the choice is correct.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function correct()
    {
        return $this->state(function (array $attributes) {
            return [
                'text' => 'correct: ' . $attributes['text'],
            ];
        });
    }

    /**
     * Indicate that the choice is incorrect.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function incorrect()
    {
        return $this->state(function (array $attributes) {
            return [
                'text' => 'incorrect: ' . $attributes['text'],
                'score' => -1 * $attributes['score'],
            ];
        });
    }
}
