<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Mail\UserApplied;
use App\Models\Project;
use App\Models\Role;
use App\Models\SavedProject;
use App\Models\Tag;
use Auth;
use DB;
use Inertia\Inertia;
use Mail;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::latest()->with('user', 'roles', 'tags');
        $roles = Role::all();
        $tags = Tag::all();

        if ($rolesParam = request()->get('roles')) {
            $projects->withRolesId($rolesParam);
        }

        if ($periodParam = request()->get('period')) {
            $period = $this->getPeriod($periodParam);

            if ($period) {
                $projects->where('created_at', '>=', $period);
            }
        }

        if ($tagsParam = request()->get('tags')) {
            $projects->withTagsId($tagsParam);
        }

        $projects->simplePaginate();
        $paginatedProjects = $projects->simplePaginate()
            ->withQueryString();

        return Inertia::render('Projects/Index', [
            'projects' => ProjectResource::collection($paginatedProjects->items()),
            'applications' => Auth::user()->applications()->pluck('project_id'),
            'roles' => $roles,
            'tags' => $tags,
            'savedProjects' => SavedProject::whereIn('project_id', $paginatedProjects->getCollection()->pluck('id')->toArray())
                ->where('user_id', user()->id)
                ->pluck('project_id'),
            'links' => [
                'nextUrl' => $paginatedProjects->nextPageUrl(),
                'previousUrl' => $paginatedProjects->previousPageUrl()
            ]
        ]);
    }

    public function show(Project $project)
    {
        $project->load('tags', 'roles', 'user');

        $user = user();

        return Inertia::render('Projects/Show', [
            'project' => new ProjectResource($project),
            'applied' => $project->didUserApply($user),
            'saved' => (bool) SavedProject::where('user_id', $user->id)
                ->where('project_id', $project->id)
                ->count()
        ]);
    }

    public function create()
    {
        $tags = Tag::all();
        $roles = Role::all();

        return Inertia::render('Projects/Create', [
            'tags' => $tags,
            'roles' => $roles
        ]);
    }

    public function store()
    {
        $this->validateProjectForm();

        DB::transaction(function () {
            $project = Auth::user()
                ->projects()
                ->create(request()->all(['name', 'description']));

            $tags = request()->get('tags');
            $newTags = $this->processNewTags($tags);

            $project->tags()->sync(array_column(array_merge($tags, $newTags), 'id'));
            $project->roles()->sync(array_column(request()->get('roles'), 'id'));
        });

        return redirect()->to(route('projects'));
    }

    public function edit(Project $project)
    {
        $this->authorize('update-project', $project);

        $tags = Tag::all();
        $roles = Role::all();
        $project->load('roles', 'tags');

        return Inertia::render('Projects/Edit', [
            'tags' => $tags,
            'roles' => $roles,
            'project' => $project
        ]);
    }

    public function update(Project $project)
    {
        $this->authorize('update-project', $project);
        $this->validateProjectForm();

        DB::transaction(function () use ($project) {
            $project->update(request()->all(['name', 'description']));

            $tags = request()->get('tags');
            $newTags = $this->processNewTags($tags);

            $project->tags()->sync(array_column(array_merge($tags, $newTags), 'id'));
            $project->roles()->sync(array_column(request()->get('roles'), 'id'));
        });

        return redirect()->route('projects.edit', $project);
    }

    public function delete(Project $project)
    {
        $this->authorize('update-project', $project);

        $project->delete();

        return redirect()->route('projects');
    }

    public function apply(Project $project)
    {
        $this->authorize('apply-for-project', $project);
        $params = $this->validateContactForm();

        DB::transaction(function () use ($project, $params) {
            if ($params['file']) {
                $path = $params['file']->storePublicly('uploads');
            }

            Auth::user()
                ->applications()
                ->attach($project->id, ['message' => $params['message'], 'file' => $path ?? null]);

            Mail::to($project->user)->queue(new UserApplied($project, auth()->user()));
        });

        return back();
    }

    public function validateProjectForm()
    {
        return request()->validate([
            'name' => ['required', 'min:5'],
            'description' => ['required', 'min:30'],
            'tags' => ['required', 'max:6'],
            'tags.*.name' => ['required', 'min:2', 'max:30'],
            'roles' => ['required'],
            'roles.*.id' => ['exists:roles,id']
        ]);
    }

    public function validateContactForm()
    {
        return request()->validate([
            'message' => 'required|min:3',
            'file' => 'nullable|file|mimes:pdf,doc,docx,odt'
        ]);
    }

    public function processNewTags($tags)
    {
        $newTags = [];

        foreach ($tags as $tag) {
            $newTags[] = Tag::updateOrCreate([
                'name' => $tag['name']
            ], ['name' => $tag['name']])->toArray();
        }

        return $newTags;
    }

    public function myProjects()
    {
        $projects = request()->get('section') === 'saved' ?
            user()->saved_projects()->withCoreRelationships()->latest() :
            user()->projects()->withCoreRelationships()->latest();

        $paginatedProjects = $projects->simplePaginate()->withQueryString();

        return Inertia::render('Projects/MyProjects', [
            'projects' => ProjectResource::collection($paginatedProjects->items()),
            'applications' => Auth::user()->applications()->pluck('project_id'),
            'links' => [
                'nextUrl' => $paginatedProjects->nextPageUrl(),
                'previousUrl' => $paginatedProjects->previousPageUrl()
            ]
        ]);
    }

    public function getPeriod($periodParam)
    {
        if ($periodParam === 'day') {
            return now()->subDay();
        }

        if ($periodParam === 'week') {
            return now()->subWeek();
        }

        if ($periodParam === 'month') {
            return now()->subMonth();
        }

        return null;
    }

    public function save(Project $project)
    {
        return user()->saved_projects()->toggle($project);
    }
}
