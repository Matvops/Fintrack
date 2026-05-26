<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as AuthUser;

class User extends AuthUser
{
    public $table = 'users';
    public $primaryKey = 'use_id';

    protected $hidden = [
        'use_password'
    ];

    public $fillable = [
        'use_id',
        'use_name',
        'use_email',
        'use_verification_token',
        'use_email_verified_at',
        'use_password',
        'created_at',
        'updated_at'
    ];


    public function getAuthPassword()
    {
        return $this->use_password;
    }

    public function goals() {
        return $this->hasMany(Goal::class, 'gls_use_id');
    }
}
