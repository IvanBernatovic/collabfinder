<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'terms_of_service' => ['required', 'accepted'],
            'password' => ['required', 'string', new Password(8)]
        ];

        if (app()->environment('production')) {
            $rules['g-recaptcha-response'] = ['required', 'captcha'];
        }

        Validator::make($input, $rules)->validate();

        $data = [
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ];

        if (!app()->environment('production')) {
            $data['email_verified_at'] = now();
        }

        return User::create($data);
    }
}
