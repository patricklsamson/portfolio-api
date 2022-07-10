<?php

namespace Database\Factories;

use App\Models\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sender' => $this->faker->company,
            'email' => $this->faker->safeEmail,
            'body' => $this->faker->paragraph,
            'type' => $this->faker->randomElement(Message::TYPES)
        ];
    }
}
