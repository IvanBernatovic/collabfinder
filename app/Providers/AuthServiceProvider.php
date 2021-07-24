<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('update-project', function ($user, $project) {
            return $user->id == $project->user_id;
        });

        Gate::define('apply-for-project', function ($user, $project) {
            return $project->user_id != $user->id && !$user->applications()->where('project_id', $project->id)->count();
        });
    }
}
