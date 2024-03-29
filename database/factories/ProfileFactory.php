<?php

namespace Database\Factories;

use App\Models\Asset;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'asset_id' => Asset::factory()->hasAddress(),
            'category' => function (array $attributes) {
                return Asset::find($attributes['asset_id'])->category;
            },
            'description' => $this->faker->sentence,
            'start_date' => $this->faker->randomElement([
                $this->faker->dateTime->format('Y-m-d H:i:s'),
                null
            ]),
            'end_date' => $this->faker->randomElement([
                $this->faker->dateTimeBetween(
                    '+1 month',
                    '+2 months'
                )->format('Y-m-d H:i:s'),
                null
            ])
        ];
    }

    /**
     * Indicate factory state
     *
     * @return Factory
     */
    public function project(): Factory
    {
        return $this->state(function () {
            return [
                'asset_id' => Asset::factory()->project()->hasAddress(),
                'category' => function (array $attributes) {
                    return Asset::find($attributes['asset_id'])->category;
                },
                'starred' => $this->faker->boolean,
                'metadata' => [
                    'project' => [
                        'role' => $this->faker->randomElement([
                            'owner',
                            'contributor'
                        ]),
                        'contributions' => [
                            'contribution_1' => $this->faker->sentence,
                            'contribution_2' => $this->faker->sentence
                        ]
                    ]
                ]
            ];
        });
    }

    /**
     * Indicate factory state
     *
     * @return Factory
     */
    public function skill(): Factory
    {
        return $this->state(function () {
            return [
                'asset_id' => Asset::factory()->skill()->hasAddress(),
                'category' => function (array $attributes) {
                    return Asset::find($attributes['asset_id'])->category;
                },
                'level' => $this->faker->randomElement(
                    array_keys(Profile::LEVELS)
                )
            ];
        });
    }
}
