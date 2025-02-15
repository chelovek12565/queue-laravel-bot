<?php


namespace App\Domain\User\Domain\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
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

}