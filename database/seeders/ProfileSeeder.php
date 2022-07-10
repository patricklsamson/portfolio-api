<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profile::factory()
            ->forUser()
            ->forAsset()
            ->create();

        Profile::factory()
            ->project()
            ->forUser()
            ->for(Asset::factory()->project())
            ->create();

        Profile::factory()
            ->skill()
            ->forUser()
            ->for(Asset::factory()->skill())
            ->create();
    }
}
