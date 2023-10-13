<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

/**
 * Class User
 * @package App\Models
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property int $age
 */
class User extends Model
{
    use HasFactory, InsertOnDuplicateKey;
    protected $primaryKey = 'user_id';
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'age',
    ];
}
