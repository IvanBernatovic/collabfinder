<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Role;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class AssignTagAndRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = Tag::all();
        $roles = Role::all();

        Project::all()->each(function ($project) use ($roles, $tags) {
            $project->roles()->sync($roles->random(random_int(1, 2))->pluck('id')->toArray());
            $project->tags()->sync($tags->random(random_int(2, 5))->pluck('id')->toArray());
        });
    }
}
