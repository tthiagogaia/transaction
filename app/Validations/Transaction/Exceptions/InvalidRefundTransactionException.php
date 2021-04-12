<?php

namespace App\Validations\Transaction\Exceptions;

use Throwable;

class InvalidRefundTransactionException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message === '' ? __('This transaction cannot be refunded') : $message;

        parent::__construct($message, $code, $previous);
    }
}
