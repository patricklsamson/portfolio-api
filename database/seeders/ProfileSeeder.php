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
    public function run(): void
    {
        Profile::factory()->forUser()->create();
        Profile::factory()->project()->forUser()->create();
        Profile::factory()->skill()->forUser()->create();
    }
}
