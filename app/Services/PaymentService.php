<?php

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Exceptions\Payment\InsufficientFundsException;
use App\Models\Payments;
use App\Models\User;
use App\Repositories\Abstracts\PaymentRepositoryInterface;
use App\Repositories\Abstracts\UserRepositoryInterface;
use App\Services\Abstracts\PaymentServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class PaymentService implements PaymentServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;
    /**
     * @var PaymentRepositoryInterface
     */
    private $paymentRepository;

    /**
     * PaymentService constructor.
     * @param PaymentRepositoryInterface $paymentRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(PaymentRepositoryInterface $paymentRepository,
                                UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->paymentRepository = $paymentRepository;
    }

    public function doPay(Payments $payment)
    {
        $payer = $payment->payer;
        $recipient = $payment->recipient;
        $cash = $payment->cash;

        if(!$this->checkBalance($payer, $cash)) {
            $this->setPaymentStatus($payment, PaymentStatus::STATUS_FAILED);

            throw new InsufficientFundsException(__('Insufficient funds'));
        }

        \DB::transaction(function () use ($payment, $payer, $recipient, $cash) {
            $this->userRepository->updateBalance($payer, $cash, false);
            $this->userRepository->updateBalance($recipient, $cash, true);

            $this->setPaymentStatus($payment, PaymentStatus::STATUS_COMPLETED);
        });

        return true;
    }

    public function addPayment(array $attributes)
    {
        $paymentData = [
            'cash' => Arr::get($attributes, 'cash'),
            'time_to_pay' => Arr::get($attributes, 'payDateTime'),
            'status' => PaymentStatus::STATUS_PENDING,
            'status_date' => now(),
        ];

        return $this->paymentRepository->createPayment(
            $paymentData,
            Arr::get($attributes, 'payerId'),
            Arr::get($attributes, 'recipientId')
        );
    }

    public function getPaymentsForTime(Carbon $timeToPay)
    {
        return $this->paymentRepository->getPendingPaymentsForTime($timeToPay);
    }

    protected function checkBalance(User $user, $balance)
    {
        return $user->metadata->balance >= $balance;
    }

    protected function setPaymentStatus(Payments $payment, $status)
    {
        return $this->paymentRepository
            ->updateById($payment->id, [
                'status' => $status,
                'status_date' => now(),
            ]);
    }
}
