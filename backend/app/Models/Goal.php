<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    public $table = 'goals';
    public $primaryKey = 'gls_id';
    public $timestamps = true;

    public $fillable = [
        'gls_id',
        'gls_use_id',
        'gls_name',
        'gls_balance',
        'gls_balance_target',
        'created_at',
        'updated_at'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'gls_use_id');
    }
}
