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
            ->hasProfiles()
            ->hasProfiles()
            ->has(Profile::factory()->project())
            ->has(Profile::factory()->project())
            ->has(Profile::factory()->skill())
            ->has(Profile::factory()->skill())
            ->hasAddress()
            ->create();

        User::factory()->create();
    }
}
