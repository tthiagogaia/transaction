<?php

namespace App\Validations\Transaction\Exceptions;

use Throwable;

class PayerNotFoundException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message === '' ? __('Payer not found') : $message;

        parent::__construct($message, $code, $previous);
    }
}
