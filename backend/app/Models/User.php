<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $table = 'users'; 
    public $primaryKey = 'use_id'; 

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
}
