<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public $table = 'transactions';
    public $primaryKey = 'tra_id';
    public $timestamps = true;

    public $fillable = [
        'tra_id',
        'tra_use_id',
        'tra_bdt_id',
        'tra_descricao',
        'tra_value',
        'tra_date',
        'tra_type',
        'created_at',
        'updated_at'
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class, 'tra_bdt_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'tra_use_id');
    }
}
