<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            MessageSeeder::class,
            AssetSeeder::class,
            ProfileSeeder::class,
            AddressSeeder::class
        ]);
    }
}
