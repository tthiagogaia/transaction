<?php

namespace App\Facades;

use App\Services\Transaction\Notification;
use Illuminate\Support\Facades\Facade;

class TransactionNotification extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Notification::class;
    }
}
