<?php

namespace App\Services\Transaction\Exceptions;

use Throwable;

class CreditNotificationUndeliveredException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message === '' ? __('Credit notification has not been delivered') : $message;
        parent::__construct($message, $code, $previous);
    }
}
