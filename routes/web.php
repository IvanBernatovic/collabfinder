<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'guest'], function () {
    Route::get('auth/login/{service}', 'Auth\SocialLoginController@redirect')->name('social-login');
    Route::get('auth/login/{service}/callback', 'Auth\SocialLoginController@callback')->name('social-login.callback');
});

Route::view('terms', 'terms');
Route::view('privacy', 'privacy');

Route::get('/', function () {
    return redirect()->to('projects');
});

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/projects', 'ProjectController@index')->name('projects');
    Route::get('/projects/create', 'ProjectController@create')->name('projects.create');
    Route::get('/projects/{project}', 'ProjectController@show')->name('projects.show');
    Route::post('/projects', 'ProjectController@store')->name('projects.store');
    Route::get('/projects/{project}/edit', 'ProjectController@edit')->name('projects.edit');
    Route::put('/projects/{project}', 'ProjectController@update')->name('projects.update');
    Route::delete('/projects/{project}', 'ProjectController@delete')->name('projects.delete');
    Route::post('/projects/{project}/apply', 'ProjectController@apply')->name('projects.apply');

    Route::get('/my-projects', 'ProjectController@myProjects')->name('my-projects');

    Route::post('/settings/email-notifications', 'SettingsController@updateNotificationSettings')
        ->name('settings.email-notifications');

    Route::get('/user/profile', 'UserProfileController@show')
        ->name('profile.show');
});
