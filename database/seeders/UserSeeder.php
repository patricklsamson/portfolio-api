<?php

namespace Database\Seeders;

use App\Models\Address;
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
    public function run()
    {
        User::factory()
            ->hasMessages(2)
            ->has(Profile::factory()->count(2)->for(
                Asset::factory()->hasAddress()
            ))
            ->has(Profile::factory()->count(2)->project()->for(
                Asset::factory()->project()->hasAddress()
            ))
            ->has(Profile::factory()->count(2)->skill()->for(
                Asset::factory()->skill()->hasAddress()
            ))
            ->hasAddress()
            ->create();
    }
}
