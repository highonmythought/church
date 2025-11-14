<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pastor;
use App\Models\Event;

class SermonFactory extends Factory
{
    public function definition(): array
    {
        return [
            'pastor_id' => Pastor::inRandomOrder()->value('id') ?? 1,
            'event_id' => Event::inRandomOrder()->value('id'),
            'bible_text' => $this->faker->regexify('[A-Z][a-z]+ \d{1,2}:\d{1,2}'),
            'summary' => $this->faker->paragraph(3),
            'date' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
