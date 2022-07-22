<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'username' => $this->faker->unique()->userName,
            'password' => Hash::make('password'),
            'metadata' => [
                'about' => $this->faker->paragraph,
                'contacts' => [
                    'email_1' => $this->faker->unique()->safeEmail,
                    'mobile_1' => $this->faker->unique()->phoneNumber,
                    'landline_1' => $this->faker->unique()->phoneNumber
                ],
                'objective' => $this->faker->paragraph,
                'websites' => [
                    'website_1' => $this->faker->unique()->url
                ]
            ]
        ];
    }
}
