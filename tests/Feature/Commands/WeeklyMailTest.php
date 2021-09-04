<?php

namespace Tests\Feature\Commands;

use App\Mail\SendProjectsMail;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mail;
use Tests\TestCase;

class WeeklyMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_commands_sends_weekly_emails()
    {
        Mail::fake();

        $this->seed();

        $project = Project::with('roles')->latest()->first();
        $user = User::first();

        $user->roles()->sync($project->roles);

        $this->artisan('run:schedule-weekly-emails');

        Mail::assertQueued(SendProjectsMail::class, 1);
    }
}
