<?php

namespace App\Validations\Transaction\Excetions;

use Throwable;

class SamePayerException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message === ''
            ? __('It is not possible to accomplish transactions from a user to the same user')
            : $message;

        parent::__construct($message, $code, $previous);
    }
}
