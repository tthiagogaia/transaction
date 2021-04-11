<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    const ALLOWED_OPERATIONS = [
        'credit',
        'refund',
    ];

    protected $fillable = [
        'type',
        'amount',
    ];
}
