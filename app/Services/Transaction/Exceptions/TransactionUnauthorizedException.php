<?php

namespace App\Services\Transaction\Exceptions;

use Throwable;

class TransactionUnauthorizedException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message === '' ? __('Transaction not authorized') : $message;
        parent::__construct($message, $code, $previous);
    }
}
