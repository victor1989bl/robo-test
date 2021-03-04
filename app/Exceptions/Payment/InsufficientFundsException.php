<?php

namespace App\Exceptions\Payment;

class InsufficientFundsException extends \Exception
{
    protected $message = 'Insufficient funds';
}
