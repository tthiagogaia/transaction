<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'payer_id',
        'operation_id',
        'authorization_code',
        'payee_id',
        'payee_type',
    ];

    public function payee()
    {
        return $this->morphTo();
    }
}
