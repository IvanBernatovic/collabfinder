<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $social_id
 * @property string $service
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TFactory|null $use_factory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialLogin newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialLogin newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialLogin query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialLogin whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialLogin whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialLogin whereService($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialLogin whereSocialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialLogin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SocialLogin whereUserId($value)
 * @mixin \Eloquent
 */
class SocialLogin extends Model
{
    use HasFactory;

    protected $guarded = [];
}
