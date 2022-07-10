<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'username' => $this->faker->unique()->userName,
            'password' => $this->faker->password,
            'objective' => $this->faker->paragraph,
            'about' => $this->faker->paragraph,
            'metadata' => [
                'contacts' => [
                    'email_1' => $this->faker->unique()->safeEmail,
                    'mobile_1' => $this->faker->unique()->phoneNumber,
                    'landline_1' => $this->faker->unique()->phoneNumber
                ],
                'websites' => [
                    'website_1' => $this->faker->unique()->url
                ]
            ]
        ];
    }
}
