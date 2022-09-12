<?php

namespace Database\Factories;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $name = $this->faker->words(2, true);
        $category = $this->faker->randomElement(
            array_filter(Asset::CATEGORIES, function ($category) {
                return $category != 'project' && $category != 'soft_skill' &&
                    $category != 'tech_skill';
            })
        );

        return [
            'name' => $name,
            'slug' => str_replace(' ', '-', $name),
            'category' => $category
        ];
    }

    /**
     * Indicate another model state
     *
     * @return Factory
     */
    public function project(): Factory
    {
        return $this->state(function () {
            return [
                'category' => 'project',
                'metadata' => [
                    'project' => [
                        'dates' => [
                            'start' => json_encode(
                                $this->faker->dateTime->format('Y-m-d H:i:s')
                            ),
                            'end' => $this->faker->randomElement([
                                json_encode(
                                    $this->faker
                                        ->dateTimeBetween(
                                            '+1 month',
                                            '+2 months'
                                        )
                                        ->format('Y-m-d H:i:s')
                                ),
                                null
                            ])
                        ],
                        'urls' => [
                            'code' => $this->faker->unique()->url,
                            'live' => $this->faker->unique()->url
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
                'category' => $this->faker->randomElement([
                    'soft_skill',
                    'tech_skill'
                ])
            ];
        });
    }
}
