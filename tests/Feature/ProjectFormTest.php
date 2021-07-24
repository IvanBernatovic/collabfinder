<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\TagSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\Assert;
use Tests\Support\AuthenticatesUser;
use Tests\TestCase;

class ProjectFormTest extends TestCase
{
    use RefreshDatabase, AuthenticatesUser;

    public function test_shows_create_project_form()
    {
        $response = $this->authenticated()
            ->get('/projects/create');

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page->component('Projects/Create'));
    }

    public function test_creating_new_project()
    {
        $this->seed(RoleSeeder::class);
        $this->seed(TagSeeder::class);

        $tag = Tag::first();

        $response = $this->authenticated()
            ->post('/projects', [
                'name' => 'Test project',
                'description' => 'A bit longer test project description',
                'roles' => [
                    [
                        'id' => Role::first()->id
                    ]
                ],
                'tags' => [
                    $tag->only('name')
                ]
            ]);

        $response->assertRedirect('/projects');
        $this->assertDatabaseHas('projects', ['name' => 'Test project']);
    }

    protected function assertResponseContainsErrors($response)
    {
        $response->assertStatus(302);
        $response->assertSessionHasErrors();
    }

    public function test_form_validation()
    {
        $this->seed(RoleSeeder::class);
        $this->seed(TagSeeder::class);
        $tag = Tag::first();

        $response = $this->authenticated()
            ->post('/projects', [
                'name' => 'Test',
                'description' => 'A bit longer test project description',
                'roles' => [
                    [
                        'id' => Role::first()->id
                    ]
                ],
                'tags' => [
                    $tag->only('name')
                ]
            ]);

        $this->assertResponseContainsErrors($response);

        $response = $this->authenticated()
            ->post('/projects', [
                'name' => 'Test project',
                'description' => 'Too short',
                'roles' => [
                    [
                        'id' => Role::first()->id
                    ]
                ],
                'tags' => [
                    $tag->only('name')
                ]
            ]);

        $this->assertResponseContainsErrors($response);

        $this->assertResponseContainsErrors($response);

        $response = $this->authenticated()
            ->post('/projects', [
                'name' => 'Test project',
                'description' => 'A bit longer test project description',
                'tags' => [
                    $tag->only('name')
                ]
            ]);

        $this->assertResponseContainsErrors($response);
    }

    public function test_shows_edit_project_form()
    {
        $project = Project::factory()
            ->hasRoles(1)
            ->hasTags(3)
            ->create();

        $response = $this->authenticated($project->user)
            ->get(route('projects.edit', $project));

        $response->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page->component('Projects/Edit'));
    }

    public function test_updating_project()
    {
        $project = Project::factory()
            ->hasRoles(1)
            ->hasTags(3)
            ->create();

        $this->assertDatabaseHas('projects', ['name' => $project->name]);
        $this->assertDatabaseMissing('projects', ['name' => 'Test project']);

        $response = $this->authenticated($project->user)
            ->put(route('projects.update', $project), [
                'name' => 'Test project',
                'description' => 'A bit longer test project description',
                'roles' => [
                    [
                        'id' => Role::first()->id
                    ]
                ],
                'tags' => [
                    Tag::first()->only('name')
                ]
            ]);

        $response->assertRedirect(route('projects.edit', $project));
        $this->assertDatabaseHas('projects', ['name' => 'Test project']);
    }

    public function test_only_owner_can_modify_project()
    {
        $project = Project::factory()
            ->hasRoles(1)
            ->hasTags(3)
            ->create();

        $user = User::factory()->create();

        $response = $this->authenticated($user)
            ->put(route('projects.update', $project), [
                'name' => 'Test project',
                'description' => 'A bit longer test project description',
                'roles' => [
                    [
                        'id' => Role::first()->id
                    ]
                ],
                'tags' => [
                    Tag::first()->only('name')
                ]
            ]);

        $response->assertStatus(403);

        $response = $this->authenticated($user)
            ->put(route('projects.delete', $project));

        $response->assertStatus(403);
    }

    public function test_deleting_project()
    {
        $project = Project::factory()
            ->hasRoles(1)
            ->hasTags(3)
            ->create(['name' => 'Test project']);

        $this->assertDatabaseHas('projects', ['name' => 'Test project']);

        $response = $this->authenticated($project->user)
            ->delete(route('projects.delete', $project));

        $response->assertRedirect(route('projects'));
        $this->assertDatabaseMissing('projects', ['name' => 'Test project']);
    }
}
