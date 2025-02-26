<?php

namespace App\Domain\Queue\Entities;

use App\Domain\User\Domain\Entities\User;
use App\Domain\Room\Entities\Room;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int         $id
 * @property string      $name
 * @property int         $user_id
 * @property int         $room_id
 * @property Carbon      $created_at
 * @property Carbon      $updated_at
 * @property Carbon      $deleted_at
 */
class Queue extends Model {

    public function room() {
        return $this->belongsTo(Room::class);
    }

    public function creator() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function users() {
        return $this->belongsToMany(User::class)->withPivot('position')->withTimestamps();
    }

    public function maxPosition(): int {
        return $this->users()->max('position')?? 0;
    }

    public function decreasePositionHigherThan(int $position): void
    {
        $this->users()->wherePivot('position', '>', $position)->decrement('position');
    }
}
