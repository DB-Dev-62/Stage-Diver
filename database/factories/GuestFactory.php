<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GuestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $days = ['DO', 'FR', 'SA'];

        return [
            'name' => $this->faker->name,
            'days' => $days,
            'number_of_person' => $this->faker->numerify(),
            'note' => $this->faker->lexify(),
        ];
    }
}
