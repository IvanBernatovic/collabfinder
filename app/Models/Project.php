<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function roles()
    {
        return $this->morphToMany(Role::class, 'roleable');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function applications()
    {
        return $this->belongsToMany(User::class, 'project_applications');
    }

    public function didUserApply($user)
    {
        return (bool) $this->applications()->where('user_id', $user->id)->count();
    }

    public function scopeWithCoreRelationships($query)
    {
        return $query->with('user', 'roles', 'tags');
    }

    public function scopeWithRolesId($projectsQuery, $rolesId)
    {
        return $projectsQuery->whereHas('roles', function ($query) use ($rolesId) {
            $query->whereIn('roles.id', $rolesId);
        });
    }

    public function scopeWithTagsId($projectsQuery, $tagsId)
    {
        return $projectsQuery->whereHas('tags', function ($query) use ($tagsId) {
            $query->whereIn('tags.id', $tagsId);
        });
    }

    public function getLinkAttribute()
    {
        return url("/projects/{$this->id}");
    }
}
