<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\Assert;
use Tests\Support\AuthenticatesUser;
use Tests\TestCase;

class SettingsController extends TestCase
{
    use RefreshDatabase, AuthenticatesUser;

    public function test_show_settings_page()
    {
        $response = $this->authenticated()->get(route('profile.show'));

        $response->assertStatus(200)->assertInertia(
            fn (Assert $page) => $page->component('Profile/Show')
        );
    }
}
