<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Tag;
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
        Tag::factory()->count(100)->create();
    }
}
