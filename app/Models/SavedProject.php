<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SavedProject extends Pivot
{
    protected $table = 'saved_projects';
}
