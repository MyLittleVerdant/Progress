<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->title(),
            'date' => $this->faker->dateTime(),
            'description' => $this->faker->text(),
            'main_picture'=>null,
            'preview_picture'=>null,
        ];
    }
}
