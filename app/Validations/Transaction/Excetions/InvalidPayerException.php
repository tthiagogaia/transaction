<?php

namespace App\Validations\Transaction\Excetions;

use Throwable;

class InvalidPayerException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message === '' ? __('Shopkeepers users only receive transactions') : $message;

        parent::__construct($message, $code, $previous);
    }
}
