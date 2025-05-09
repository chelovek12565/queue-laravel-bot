<?php

namespace App\Domain\Room\Entities;

use App\Domain\Queue\Entities\Queue;
use App\Domain\User\Domain\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;


/**
 * @property int         $id
 * @property int         $user_id
 * @property string      $name
 * @property string|null $description
 * @property Carbon      $created_at
 * @property Carbon      $updated_at
 */
class Room extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function users() {
        return $this->belongsToMany(User::class, 'room_user')->withTimestamps();
    }

    public function creator() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function queues() {
        return $this->hasMany(Queue::class);
    }
}
