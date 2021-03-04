<?php

namespace App\Repositories;

use App\Enums\PaymentStatus;
use App\Models\Payments;
use App\Repositories\Abstracts\PaymentRepositoryInterface;
use Illuminate\Support\Carbon;

class PaymentRepository extends BaseRepository implements PaymentRepositoryInterface
{
    /**
     * UserRepository constructor.
     * @param Payments $model
     */
    public function __construct(Payments $model)
    {
        $this->model = $model;
    }

    public function getPendingPaymentsForTime(Carbon $timeToPay)
    {
        return $this->model
            ->where('status', PaymentStatus::STATUS_PENDING)
            ->where('time_to_pay', '<=', $timeToPay)
            ->get('*');
    }

    public function createPayment($data, $payerId, $recipientId)
    {
        /** @var Payments $payment */
        $payment = $this->model->create(array_merge(
            $data,
            [
                'payer_user_id' => $payerId,
                'recipient_user_id' => $recipientId
            ]
        ));

        return $payment->fresh();
    }
}
