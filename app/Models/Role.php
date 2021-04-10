<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const CONSUMER   = 'consumer';
    const SHOPKEEPER = 'shopkeeper';

    protected $fillable = [
        'name',
        'label',
        'description',
    ];
}
