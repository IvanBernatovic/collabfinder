<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * 
 *
 * @property int $id
 * @property int $project_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SavedProject newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SavedProject newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SavedProject query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SavedProject whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SavedProject whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SavedProject whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SavedProject whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SavedProject whereUserId($value)
 * @mixin \Eloquent
 */
class SavedProject extends Pivot
{
    protected $table = 'saved_projects';
}
