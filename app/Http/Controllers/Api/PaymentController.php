<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\PaymentRequest;
use App\Http\Resources\Payment\PaymentResource;
use App\Services\Abstracts\PaymentServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PaymentController extends Controller
{
    /**
     * @var PaymentServiceInterface
     */
    private $paymentService;

    /**
     * PaymentController constructor.
     * @param PaymentServiceInterface $paymentService
     */
    public function __construct(PaymentServiceInterface $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function pay(PaymentRequest $request)
    {
        return new PaymentResource(
            $this->paymentService->addPayment($request->validated())
        );
    }
}
