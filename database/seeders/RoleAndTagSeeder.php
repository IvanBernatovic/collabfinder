<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleAndTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(TagSeeder::class);
    }
}
