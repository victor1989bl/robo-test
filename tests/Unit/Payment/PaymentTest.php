<?php

namespace Tests\Unit\Payment;

use App\Enums\PaymentStatus;
use App\Exceptions\Payment\InsufficientFundsException;
use App\Models\Payments;
use App\Models\User;
use App\Models\UserMetadata;
use App\Repositories\Abstracts\PaymentRepositoryInterface;
use App\Repositories\Abstracts\UserRepositoryInterface;
use App\Services\Abstracts\PaymentServiceInterface;
use Tests\Mock\Repositories\PaymentRepository;
use Tests\Mock\Repositories\UserRepository;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    /** @var PaymentServiceInterface */
    protected $paymentService;

    public function setUp():void
    {
        parent::setUp();

        app()->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
        app()->bind(UserRepositoryInterface::class, UserRepository::class);

        $this->paymentService = app()->make(PaymentServiceInterface::class);
    }

    protected function makeUser($id, $balance) {
        $user = User::factory()->make(['id' => $id]);
        $user->metadata = UserMetadata::factory()->makeOne([
            'user_id' => $user->id,
            'balance' => $balance
        ]);

        return $user;
    }

    /**
     * @return void
     */
    public function testAddPayment()
    {
        $payerId = 100;
        $recipientId = 200;
        $cash = 1000;

        $payment = $this->paymentService->addPayment([
            'cash' => $cash,
            'payDateTime' => now(),
            'payerId' => $payerId,
            'recipientId' => $recipientId,
        ]);

        $this->assertIsNumeric($payment->cash);
        $this->assertEquals($payment->cash, $cash);

        $this->assertNotEmpty($payment->time_to_pay);

        $this->assertEquals($payment->status, PaymentStatus::STATUS_PENDING);
        $this->assertNotEmpty($payment->status_date);

        $this->assertEquals($payment->payer->id, $payerId);
        $this->assertEquals($payment->recipient->id, $recipientId);
    }

    public function testGetPaymentsForTime()
    {
        $payments = $this->paymentService->getPaymentsForTime(now());

        $payments->each(function($payment){
            $this->assertIsNumeric($payment->cash);

            $this->assertNotEmpty($payment->time_to_pay);
            $this->assertTrue(now() > $payment->time_to_pay);

            $this->assertContains($payment->status, PaymentStatus::getValues());
            $this->assertNotEmpty($payment->status_date);
        });
    }

    public function testDoPayWithLowBalance()
    {
        $payer = $this->makeUser(100, 1000);
        $recipient = $this->makeUser(200, 1000);

        /** @var Payments $payment */
        $payment = Payments::factory()->makeOne([
            'cash' => 2000
        ]);
        $payment->payer()->associate($payer);
        $payment->recipient()->associate($recipient);

        $this->expectException(InsufficientFundsException::class);
        $this->paymentService->doPay($payment);
    }

    public function testDoPay()
    {
        $payer = $this->makeUser(100, 3000);
        $recipient = $this->makeUser(200, 1000);

        /** @var Payments $payment */
        $payment = Payments::factory()->makeOne([
            'cash' => 2000
        ]);
        $payment->payer()->associate($payer);
        $payment->recipient()->associate($recipient);

        $pay = $this->paymentService->doPay($payment);
        $this->assertTrue($pay);
    }
}
