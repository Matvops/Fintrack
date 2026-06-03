<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    public $table = 'budgets';
    public $primaryKey = 'bdt_id';
    public $timestamps = true;

    public $fillable = [
        'bdt_id',
        'bdt_use_id',
        'bdt_name',
        'bdt_limit',
        'bdt_current_expense',
        'bdt_color',
        'created_at',
        'updated_at',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'bdt_use_id');
    }

    public function transactions() {
        return $this->hasMany(Transaction::class, 'bdt_tra_id');
    }
}
