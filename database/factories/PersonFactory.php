<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'year' => $this->faker->randomElement(['2022', '2023', '2024']),
            'registered' => $this->faker->randomElement(['Yes', 'NO']),
            'friday' => $this->faker->dayOfMonth('Freitag'),
            'friday_beer' => $this->faker->randomElement(['Yes', 'NO']),
            'saturday' => $this->faker->dayOfMonth('Samstag'),
            'saturday_beer' => $this->faker->randomElement(['Yes', 'NO']),
            'sunday' => $this->faker->dayOfMonth('Sonntag'),
            'sunday_beer' => $this->faker->randomElement(['Yes', 'NO']),
            't_shirt_size' => $this->faker->randomElement(['S', 'M', 'L','XL', 'XXL']),
            't_shirt_picked_up' => $this->faker->randomElement(['Yes', 'NO']),
            'food' => $this->faker->randomElement(['Fleisch', 'Vegetarier', 'Veganer']),
            'allergies' => $this->faker->sentence(5),
            'other' => $this->faker->sentence(5),
            'note' => $this->faker->sentence(5),
        ];
    }
}
