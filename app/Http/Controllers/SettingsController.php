<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function updateNotificationSettings(Request $request)
    {
        $request->validate([
            'tags' => 'array',
            'roles' => 'array',
            'tags.*.id' => ['exists:tags,id'],
            'roles.*.id' => ['exists:roles,id']
        ]);

        $user = user();
        $user->tags()->sync($request->get('tags'));
        $user->roles()->sync($request->get('roles'));

        if ($request->wantsJson()) {
            return response()->json();
        }

        return back();
    }
}
