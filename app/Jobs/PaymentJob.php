<?php

namespace App\Jobs;

use App\Models\Payments;
use App\Services\Abstracts\PaymentServiceInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @param PaymentServiceInterface $paymentService
     * @return void
     */
    public function handle(PaymentServiceInterface $paymentService)
    {
        $payments = $paymentService->getPaymentsForTime(now()->endOfHour());

        $payments->each(function (Payments $payment) use ($paymentService) {
            $paymentService->doPay($payment);
        });
    }
}
