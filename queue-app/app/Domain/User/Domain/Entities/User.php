<?php


namespace App\Domain\User\Domain\Entities;

use App\Domain\Room\Entities\Room;
use App\Domain\Queue\Entities\Queue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


/**
 * @property int         $id
 * @property int         $tgid
 * @property string      $first_name
 * @property string|null $second_name
 * @property string|null $username
 * @property Carbon      $created_at
 * @property Carbon      $updated_at
 */
class User extends Model
{
    protected $guarded = [];
    
    public function rooms() {
        return $this->belongsToMany(Room::class, 'room_user', 'user_id', 'room_id')->withTimestamps();
    }

    public function admin() {
        return $this->hasMany(Room::class);
    }

    public function queues() {
        return $this->belongsToMany(Queue::class)->withPivot('position')->withTimestamps();
    }
}
