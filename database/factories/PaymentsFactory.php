<?php

namespace Database\Factories;

use App\Enums\PaymentStatus;
use App\Models\Payments;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PaymentsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payments::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cash' => $this->faker->numberBetween(0, 999),
            'time_to_pay' => $this->faker->dateTime(),
            'status' => $this->faker->randomElement(PaymentStatus::getValues()),
            'status_date' => $this->faker->dateTime(),
        ];
    }
}
