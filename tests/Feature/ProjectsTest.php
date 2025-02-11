<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Role;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\Support\AuthenticatesUser;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    use RefreshDatabase, AuthenticatesUser;

    public function test_show_projects_page()
    {
        Project::factory()->times(10)->create();

        $response = $this->authenticated()
            ->get('/projects');

        $response->assertStatus(200)
            ->assertInertia(
                fn(Assert $page) => $page->component('Projects/Index')
                    ->has('projects', 10)
            );
    }

    public function test_show_single_project_page()
    {
        $project = Project::factory()->create();

        $response = $this->authenticated()
            ->get(route('projects.show', $project));

        $response->assertStatus(200)
            ->assertInertia(
                fn(Assert $page) => $page->component('Projects/Show')
                    ->has('project')
            );
    }

    public function test_only_logged_in_users_can_see_projects()
    {
        $project = Project::factory()->create();

        $response = $this->get(route('projects.show', $project));

        $response->assertRedirect('/login');

        $response = $this->get(route('projects'));

        $response->assertRedirect('/login');

        $response = $this->getJson(route('projects'));
        $response->assertStatus(401);
    }

    public function test_filters_by_tags()
    {
        $tag = Tag::factory()->create([
            'name' => 'test tag'
        ]);

        Project::factory()->hasAttached($tag)
            ->create();

        Project::factory()->has(Tag::factory()->count(random_int(0, 3)))
            ->count(10)
            ->create();

        $response = $this->authenticated()
            ->get("/projects?tags[]={$tag->id}");

        $response->assertStatus(200)
            ->assertInertia(
                fn(Assert $page) => $page->component('Projects/Index')
                    ->has('projects', 1)
            );
    }

    public function test_filters_by_roles()
    {
        $role = Role::factory()->create([
            'title' => 'Just a dev'
        ]);

        Project::factory()->hasAttached($role)
            ->create();

        Project::factory()->has(Role::factory()->count(random_int(0, 3)))
            ->count(10)
            ->create();

        $response = $this->authenticated()
            ->get("/projects?roles[]={$role->id}");

        $response->assertStatus(200)
            ->assertInertia(
                fn(Assert $page) => $page->component('Projects/Index')
                    ->has('projects', 1)
            );
    }

    public function test_pagination()
    {
        $projects = Project::factory()->has(Role::factory()->count(random_int(1, 3)))
            ->has(Tag::factory()->count(random_int(1, 3)))
            ->count(100)
            ->create();

        $response = $this->authenticated()
            ->get("/projects");

        $response->assertStatus(200)
            ->assertInertia(
                fn(Assert $page) => $page->component('Projects/Index')
                    ->has('projects', 15)
            );

        $secondPageResponse = $this->authenticated()
            ->get("/projects?page=2");

        $secondPageResponse->assertStatus(200)
            ->assertInertia(
                fn(Assert $page) => $page->component('Projects/Index')
                    ->has('projects', 15)
            );
    }

    public function test_show_my_projects_page()
    {
        $user = User::factory()->withProjects(7)->create();

        $this->assertEquals(7, $user->projects()->count());

        $response = $this->authenticated($user)
            ->get('/my-projects');

        $response->assertStatus(200)
            ->assertInertia(
                fn(Assert $page) => $page->component('Projects/MyProjects')
                    ->has('projects', 7)
            );
    }
}
