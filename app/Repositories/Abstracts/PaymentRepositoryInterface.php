<?php

namespace App\Repositories\Abstracts;

use Illuminate\Support\Carbon;

interface PaymentRepositoryInterface extends BaseRepositoryInterface
{
    public function getPendingPaymentsForTime(Carbon $timeToPay);

    public function createPayment($data, $payerId, $recipientId);
}
