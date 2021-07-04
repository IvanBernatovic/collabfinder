<?php

use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;

function customRequestCaptcha()
{
    return new \ReCaptcha\RequestMethod\Post();
}

/**
 * 
 * @return User|null 
 * @throws BindingResolutionException 
 */
function authUser()
{
    return auth()->user();
}
