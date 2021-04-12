<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'payer_id',
        'operation_id',
        'authorization_code',
        'payee_id',
        'payee_type',
        'refunded_at',
    ];

    public function payee()
    {
        return $this->morphTo();
    }

    public function payer()
    {
        return $this->belongsTo(User::class);
    }

    public function operation()
    {
        return $this->belongsTo(Operation::class);
    }
}
