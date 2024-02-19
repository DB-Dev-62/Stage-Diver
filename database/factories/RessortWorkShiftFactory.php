<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class RessortWorkShiftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $days = ['FR', 'SA', 'SO'];
        $randomDay = Arr::random($days);

        return [
            'day' => $randomDay,
            'time_start' => $this->faker->randomDigitNot(0),
            'time_end' => $this->faker->randomDigitNot(0),
        ];
    }
}
