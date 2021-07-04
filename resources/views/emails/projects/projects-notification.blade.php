@component('mail::message')
## Hi, {{ $user->name }}!

__Here's the list of projects you could be interested in:__

@foreach($_projects as $project)
## [{{ $project->name }}]({{$project->link}})
{{ substr($project->description, 0, 300) . (strlen($project->description) > 300 ? '...' : '') }}
<br>
<br>
@endforeach

@if($projects->count() > 10)
...and more.
@endif

Check them all on [CollabFinder](https://app.collabfinder.net).

Thanks,<br>
{{ config('app.name') }}

@component('mail::subcopy')
    You can unsubscribe from these emails [here](https://app.collabfinder.net/user/profile).
@endcomponent
@endcomponent
