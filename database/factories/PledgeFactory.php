<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PledgeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'amount' => $this->faker->randomFloat(2, 1000, 100000),
            'expected_payment_date' => $this->faker->dateTimeBetween('now', '+3 months'),
            'notes' => $this->faker->sentence(10),
            'amount_paid' => $this->faker->randomFloat(2, 0, 50000),
            'payment_date' => $this->faker->optional()->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
