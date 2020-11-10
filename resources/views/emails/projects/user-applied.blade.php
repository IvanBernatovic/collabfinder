@component('mail::message')
# Hi, {{ $project->user->name }}!

User {{ $user->name }} applied to your project "{{ $project->name }}".

@component('mail::panel')
{{ $user->applicationFor($project)->message }}    
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent