<?php

namespace App\Http\Requests;

use App\Rules\AfterHoursRule;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'payerId' => 'required|exists:users,id',
            'recipientId' => 'required|exists:users,id',
            'cash' => 'required|numeric|min:1',
            'payDateTime' => ['required', 'date', new AfterHoursRule],
        ];
    }

    public function validated()
    {
        $validated = parent::validated();
        $payDateTime = Carbon::parse($validated['payDateTime']);

        $validated['payDateTime'] = $payDateTime
            ->setMinute(0)
            ->format('Y-m-d H:i');

        return $validated;
    }
}
