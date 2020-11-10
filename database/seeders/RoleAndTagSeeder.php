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
        Role::factory()->count(20)->create();
        Tag::factory()->count(100)->create();
    }
}
