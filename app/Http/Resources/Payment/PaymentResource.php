<?php

namespace App\Http\Resources\Payment;

use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'cash' => $this->cash,
            'status' => $this->status,
            'payDateTime' => $this->time_to_pay,

            'payer' => new UserResource($this->payer),
            'recipient' => new UserResource($this->recipient),
        ];
    }
}
