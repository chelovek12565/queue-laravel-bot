<?php


namespace App\Domain\User\Domain\Entities;

use App\Domain\Room\Entities\Room;
use App\Domain\Queue\Entities\Queue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;


/**
 * @property int         $id
 * @property int         $tgid
 * @property string      $first_name
 * @property string|null $second_name
 * @property string|null $username
 * @property Carbon      $created_at
 * @property Carbon      $updated_at
 */
class User extends Authenticatable implements AuthenticatableContract
{
    protected $guarded = [];

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->getAttribute($this->getAuthIdentifierName());
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return null; // Telegram users don't have passwords
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string|null
     */
    public function getRememberToken()
    {
        return null; // Not using remember tokens for Telegram auth
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string  $value
     * @return void
     */
    public function setRememberToken($value)
    {
        // Not using remember tokens for Telegram auth
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    /**
     * Find user by Telegram ID
     *
     * @param int $tgid
     * @return User|null
     */
    public static function findByTgid(int $tgid): ?self
    {
        return static::where('tgid', $tgid)->first();
    }

    /**
     * Create or update user by Telegram ID
     *
     * @param int $tgid
     * @param array $data
     * @return User
     */
    public static function createOrUpdateByTgid(int $tgid, array $data): self
    {
        return static::updateOrCreate(
            ['tgid' => $tgid],
            $data
        );
    }

    public function rooms() {
        return $this->belongsToMany(Room::class, 'room_user')->withTimestamps();
    }

    public function admin() {
        return $this->hasMany(Room::class);
    }

    public function queues() {
        return $this->belongsToMany(Queue::class)->withPivot('position')->withTimestamps();
    }
}
