@component('mail::message')
    # Hi, {{ $project->user->name }}!

    User {{ $user->name }} applied for your project "{{ $project->name }}".

    @component('mail::panel')
        {{ $user->applicationForProject($project)->pivot->message }}
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
