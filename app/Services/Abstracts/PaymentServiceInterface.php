<?php

namespace App\Services\Abstracts;

use App\Models\Payments;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

interface PaymentServiceInterface
{
    public function doPay(Payments $payment);

    /** @return Payments */
    public function addPayment(array $attributes);

    /** @return Collection */
    public function getPaymentsForTime(Carbon $timeToPay);
}
