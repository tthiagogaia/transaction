<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    const CREDIT = 'credit';
    const REFUND = 'refund';

    const ALLOWED_OPERATIONS = [
        self::CREDIT,
        self::REFUND,
    ];

    protected $fillable = [
        'type',
        'amount',
    ];
}
