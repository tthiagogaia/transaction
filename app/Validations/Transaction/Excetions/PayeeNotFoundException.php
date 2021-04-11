<?php

namespace App\Validations\Transaction\Excetions;

use Throwable;

class PayeeNotFoundException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message === '' ? __('Payee not found') : $message;

        parent::__construct($message, $code, $previous);
    }
}
