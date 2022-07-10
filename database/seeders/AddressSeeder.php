<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Address::factory()
            ->for(User::factory(), 'parentable')
            ->create();

        Address::factory()
            ->for(Asset::factory(), 'parentable')
            ->create();
    }
}
