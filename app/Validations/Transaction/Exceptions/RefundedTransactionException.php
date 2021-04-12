<?php

namespace App\Validations\Transaction\Exceptions;

use Throwable;

class RefundedTransactionException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message === '' ? __('This transaction has already been refunded') : $message;

        parent::__construct($message, $code, $previous);
    }
}
