<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use DB;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('social');
    }

    public function redirect($service)
    {
        return Socialite::driver($service)->redirect();
    }

    public function callback($service)
    {
        $user = DB::transaction(function () use ($service) {
            $serviceUser = Socialite::driver($service)->user();

            $email = $serviceUser->getEmail();

            $user = $this->getExistingUser($serviceUser, $email, $service);

            if (!$user) {
                $user = User::create([
                    'name' => $serviceUser->getName(),
                    'email' => $email,
                    'password' => '',
                    'email_verified_at' => now()
                ]);
            }

            if ($this->needsToCreateSocial($user, $service)) {
                $user->social_login()->create([
                    'user_id' => $user->id,
                    'social_id' => $serviceUser->getId(),
                    'service' => $service,
                ]);
            }

            return $user;
        });

        Auth::login($user, true);

        return redirect('/projects');
    }

    public function needsToCreateSocial(User $user, $service)
    {
        return !$user->hasSocialLinked($service);
    }

    public function getExistingUser($serviceUser, $email, $service)
    {
        return User::where('email', $email)->orWhereHas('social_login', function ($q) use ($serviceUser, $service) {
            $q->where('social_id', $serviceUser->getId())->where('service', $service);
        })->first();
    }
}
