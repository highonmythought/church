<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'date' => $this->faker->dateTimeBetween('-1 month', '+2 months'),
            'location' => $this->faker->city(),
            'description' => $this->faker->sentence(8),
        ];
    }
}
