<?php

namespace App\Console\Commands;

use App\Mail\SendProjectsMail;
use App\Models\Project;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ScheduleWeeklyEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:schedule-weekly-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedules weekly emails to notify about new projects';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected function getProjects($roleables, $taggables)
    {
        return Project::where('created_at', '>=', now()->subtract('days', 7))
            ->with(['roles', 'tags'])
            ->withRolesId($roleables->pluck('role_id')->toArray())
            ->orWhere(function ($q) use ($taggables) {
                $q->withTagsId($taggables->pluck('tag_id')->toArray());
            })->get();
    }

    /**
     * 
     * @param Collection $items 
     * @param int $userId 
     * @param Collection $groupedPreferences 
     * @param string $accessor 
     * 
     * @return bool 
     */
    protected function getItemsMatch($items, $userId, $groupedPreferences, $accessor)
    {
        // if items are empty and user has no items preferences
        if (!($items->count() && $groupedPreferences->has($userId))) {
            return false;
        }

        return (bool) $items
            ->whereIn('id', $groupedPreferences[$userId]->pluck($accessor)->toArray())
            ->count();
    }

    protected function filterProjectsForUser($projects, $userId, $groupedRoleables, $groupedTaggables)
    {
        return $projects
            ->filter(function ($project) use ($userId, $groupedRoleables, $groupedTaggables) {
                $rolesMatch = $this->getItemsMatch($project->roles, $userId, $groupedRoleables, 'role_id');
                $tagsMatch = $this->getItemsMatch($project->tags, $userId, $groupedTaggables, 'tag_id');

                // filter project only if there's a role or tag match
                return $rolesMatch || $tagsMatch;
            });
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $taggables = DB::table('taggables')
            ->select('taggable_id', 'tag_id')
            ->where('taggable_type', User::class)
            ->get();

        $roleables = DB::table('roleables')
            ->select('roleable_id', 'role_id')
            ->where('roleable_type', User::class)
            ->get();

        // get all projects for given roles and tags
        $projects = $this->getProjects($roleables, $taggables);

        $userIds = array_unique(
            array_merge(
                $taggables->pluck('taggable_id')->toArray(),
                $roleables->pluck('roleable_id')->toArray()
            )
        );

        $users = User::find($userIds);

        $groupedTaggables = $taggables->groupBy('taggable_id');
        $groupedRoleables = $roleables->groupBy('roleable_id');

        // filter projects per user based on their roles and tags preferences
        foreach ($users as $user) {
            $filteredProjects = $this->filterProjectsForUser(
                $projects,
                $user->id,
                $groupedRoleables,
                $groupedTaggables
            );

            if ($filteredProjects->count()) {
                // send the email to the user for given projects
                Mail::to($user)->queue(new SendProjectsMail($user, $filteredProjects));
            }
        }

        return 0;
    }
}
