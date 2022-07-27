<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory()
            ->hasMessages(2)
            ->has(Profile::factory()->for(
                Asset::factory()->hasAddress()
            ))
            ->has(Profile::factory()->for(
                Asset::factory()->hasAddress()
            ))
            ->has(Profile::factory()->project()->for(
                Asset::factory()->project()->hasAddress()
            ))
            ->has(Profile::factory()->project()->for(
                Asset::factory()->project()->hasAddress()
            ))
            ->has(Profile::factory()->skill()->for(
                Asset::factory()->skill()->hasAddress()
            ))
            ->has(Profile::factory()->skill()->for(
                Asset::factory()->skill()->hasAddress()
            ))
            ->hasAddress()
            ->create();

        User::factory()->create();
    }
}
