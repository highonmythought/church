<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PastorFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'rank' => $this->faker->randomElement(['Senior Pastor', 'Assistant Pastor', 'Youth Pastor', 'Resident Pastor', 'Evangelist']),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
        ];
    }
}
