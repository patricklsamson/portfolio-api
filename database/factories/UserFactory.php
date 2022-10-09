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
            'first_name' => $this->faker->firstName,
            'middle_name' => $this->faker->lastName,
            'last_name' => $this->faker->lastName,
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

    /**
     * Indicate factory state
     *
     * @return Factory
     */
    public function admin(): Factory {
        return $this->state(function () {
            return ['username' => 'admin'];
        });
    }

    /**
     * Indicate factory state
     *
     * @param ?string $username
     *
     * @return Factory
     */
    public function customUsername(?string $username = 'dummy'): Factory {
        return $this->state(function () use ($username) {
            return ['username' => $username];
        });
    }
}
