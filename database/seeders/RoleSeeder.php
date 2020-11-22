<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'Back-end developer', 'Front-end developer', 'Full stack developer', 'UI/UX designer',
            'DevOps engineer', 'Graphic designer', 'Mobile app developer', 'Desktop app developer', 'Data scientist',
            'Audio producer', 'Composer', '3D artist', 'Animator', 'Marketing specialist', 'Photographer',
            'Video producer', '2D artist', 'Translator', 'Content writer', 'Accountant', 'Corporate lawyer',
            'Social media manager'
        ];

        $rolesToInsert = collect($roles)->map(function ($role) {
            return ['title' => $role, 'created_at' => now(), 'updated_at' => now()];
        })->toArray();

        Role::insert($rolesToInsert);
    }
}
