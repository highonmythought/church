<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'photo_path' => null,
            'acquired_date' => $this->faker->dateTimeBetween('-2 years', 'now'),
        ];
    }
}
