<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(8),
            'user_id' => User::factory(),
            'description' => $this->faker->sentences(random_int(15, 25), true)
        ];
    }
}
