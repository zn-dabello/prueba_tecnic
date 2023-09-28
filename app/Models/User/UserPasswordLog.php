<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class UserPasswordLog extends Model
{
    protected $fillable = [
        'user_id', 'password'
    ];

    protected $table = 'user_password_log';

    public $timestamps = false;

}
