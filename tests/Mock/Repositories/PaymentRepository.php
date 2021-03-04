<?php


namespace Tests\Mock\Repositories;


use App\Models\Payments;
use App\Models\User;
use App\Repositories\Abstracts\PaymentRepositoryInterface;
use Illuminate\Support\Carbon;

class PaymentRepository implements PaymentRepositoryInterface
{

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function getById($id)
    {
        // TODO: Implement getById() method.
    }

    public function updateById($id, $data)
    {
        return Payments::factory()->make(array_merge(
            ['id' => $id],
            $data
        ));
    }

    public function create($data)
    {
        // TODO: Implement create() method.
    }

    public function getPendingPaymentsForTime(Carbon $timeToPay)
    {
        return Payments::factory([
            'time_to_pay' => $timeToPay->subHour()
        ])
            ->count(5)
            ->make();
    }

    public function createPayment($data, $payerId, $recipientId)
    {
        $payer = User::factory()->makeOne([
            'id' => $payerId
        ]);

        $recipient = User::factory()->makeOne([
            'id' => $recipientId
        ]);

        /** @var Payments $payment */
        $payment = Payments::factory()->makeOne($data);
        $payment->payer()->associate($payer);
        $payment->recipient()->associate($recipient);

        return $payment;
    }
}
