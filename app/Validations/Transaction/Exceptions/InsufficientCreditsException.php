<?php

namespace App\Validations\Transaction\Exceptions;

use Throwable;

class InsufficientCreditsException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message === '' ? __('You don\'t have enough credits to complete this transaction') : $message;

        parent::__construct($message, $code, $previous);
    }
}
