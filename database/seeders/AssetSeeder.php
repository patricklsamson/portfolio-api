<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Address;
use App\Models\Profile;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Asset::factory()->create();
        Asset::factory()->project()->create();
        Asset::factory()->skill()->create();
    }
}
