<?php

use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use ReCaptcha\RequestMethod\Post;

/**
 * @codeCoverageIgnore
 * 
 * @return Post 
 */
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
