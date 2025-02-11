<?php

namespace Tests\Feature;

use App\Mail\UserApplied;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mail;
use Tests\Support\AuthenticatesUser;
use Tests\TestCase;

class ProjectApplicationTest extends TestCase
{
    use RefreshDatabase, AuthenticatesUser;

    public function test_user_can_apply_for_project()
    {
        $project = Project::factory()
            ->hasRoles(1)
            ->hasTags(3)
            ->create();

        $user = User::factory()->create();

        $response = $this->authenticated($user)
            ->post(route('projects.apply', $project), [
                'message' => 'Test application'
            ]);

        $response->assertStatus(302);
        $this->assertDatabaseCount('project_applications', 1);
    }

    public function test_notify_owner_when_someone_applies()
    {
        Mail::fake();

        $project = Project::factory()
            ->hasRoles(1)
            ->hasTags(3)
            ->create();

        $user = User::factory()->create();

        $response = $this->authenticated($user)
            ->post(route('projects.apply', $project), [
                'message' => 'Test application'
            ]);

        Mail::assertQueued(UserApplied::class);
    }

    public function test_user_can_not_apply_twice_for_same_project()
    {
        $project = Project::factory()
            ->hasRoles(1)
            ->hasTags(3)
            ->create();

        $user = User::factory()->create();

        $response = $this->authenticated($user)
            ->post(route('projects.apply', $project), [
                'message' => 'Test application'
            ]);

        $response = $this->authenticated($user)
            ->post(route('projects.apply', $project), [
                'message' => 'Test application'
            ]);

        $response->assertStatus(403);
    }

    public function test_owner_can_not_apply_for_his_project()
    {
        $project = Project::factory()
            ->hasRoles(1)
            ->hasTags(3)
            ->create();

        $response = $this->authenticated($project->user)
            ->post(route('projects.apply', $project), [
                'message' => 'Test application'
            ]);

        $response->assertStatus(403);
    }

    public function test_application_validation()
    {
        $project = Project::factory()
            ->hasRoles(1)
            ->hasTags(3)
            ->create();

        $user = User::factory()->create();

        $response = $this->authenticated($user)
            ->post(route('projects.apply', $project));

        $response->assertStatus(302);
        $response->assertSessionHasErrors();
    }
}
