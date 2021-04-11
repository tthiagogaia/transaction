<?php

namespace App\Facades;

use App\Services\Transaction\Authorization;
use Illuminate\Support\Facades\Facade;

class TransactionAuthorization extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Authorization::class;
    }
}
