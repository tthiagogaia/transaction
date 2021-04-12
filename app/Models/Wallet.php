<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    const DEFAULT_VALUE = 100;

    protected $fillable = [
        'account_id',
        'account_type',
        'amount',
    ];

    public function account()
    {
        return $this->morphTo();
    }
}
