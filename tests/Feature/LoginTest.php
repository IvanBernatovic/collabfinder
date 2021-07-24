<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_show_login_page()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_successful_login_try()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertRedirect('/projects');
    }

    public function test_unsuccessful_login_try()
    {
        $response = $this->post('/login', [
            'email' => 'idontexisttest.com',
            'password' => 'password'
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'email' => 'These credentials do not match our records.'
        ]);
    }

    public function test_wrong_password()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password2'
        ]);

        $response->assertSessionHasErrors([
            'email' => 'These credentials do not match our records.'
        ]);
    }
}
