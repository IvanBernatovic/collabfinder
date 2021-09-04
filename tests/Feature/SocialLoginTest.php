<?php

namespace Tests\Feature;

use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Mockery;
use Tests\TestCase;

class SocialLoginTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function mockSocialiteFacade($email = null, $name = null, $token = null, $id = null)
    {
        $socialiteUser = Mockery::mock(\Laravel\Socialite\Two\User::class);

        $socialiteUser->shouldReceive('getId')
            ->andReturn($id ?? '1234567890')
            ->shouldReceive('getEmail')
            ->andReturn($email ?? $this->faker->email)
            ->shouldReceive('getName')
            ->andReturn($name ?? $this->faker->name);

        $provider = $this->createMock(\Laravel\Socialite\Two\GoogleProvider::class);
        $provider->expects($this->any())
            ->method('user')
            ->willReturn($socialiteUser);

        $provider->expects($this->any())
            ->method('stateless')
            ->willReturn($provider);

        $stub = $this->createMock(Socialite::class);
        $stub->expects($this->any())
            ->method('driver')
            ->willReturn($provider);

        // Replace Socialite Instance with our mock
        $this->app->instance(Socialite::class, $stub);
    }

    public function test_get_error_for_unsupported_service()
    {
        $response = $this->get(route('social-login', 'randomservice'));

        $response->assertStatus(404);
    }

    public function test_user_is_redirected_to_google_login()
    {
        $response = $this->get(route('social-login', 'google'));

        $this->assertStringContainsString('accounts.google.com/o/oauth2/auth', $response->getTargetUrl());
    }

    public function test_user_can_sign_in_with_google()
    {
        $email = $this->faker->email;
        $this->mockSocialiteFacade($email);

        $response = $this->get(route('social-login.callback', 'google'));

        // $this->assertStringContainsString(config('app.client_url') . '/auth/social', $response->getTargetUrl());

        $response->assertRedirect('/projects');
        $this->assertDatabaseHas('users', [
            'email' => $email,
        ]);
    }

    public function test_social_login_exception_returns_redirect()
    {
        $stub = $this->createMock(Socialite::class);

        $stub->expects($this->any())
            ->method('driver')
            ->willThrowException(new Exception('Issue'));

        $response = $this->get(route('social-login.callback', 'google'));

        $response->assertStatus(500);
    }
}
