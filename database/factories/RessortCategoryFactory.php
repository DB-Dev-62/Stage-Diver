<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class RessortCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //$days = ['FR', 'SA', 'SO'];
        //$randomDay = Arr::random($days);

        return [
            'name' => $this->faker->name,
        ];
    }
}
