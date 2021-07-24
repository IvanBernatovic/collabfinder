<?php

namespace Tests\Support;

use App\Models\User;

trait AuthenticatesUser
{
    protected User $user;

    public function setupUser()
    {
        $attributes = [];

        if (method_exists($this, 'getUserFactoryAttributes')) {
            $attributes = $this->getUserFactoryAttributes();
        }

        $this->user = User::factory()->create($attributes);
    }

    public function authenticated($user = null)
    {
        return $this->actingAs($user ?? $this->user);
    }
}
