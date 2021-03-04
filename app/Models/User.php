<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function metadata()
    {
        return $this->hasOne(UserMetadata::class);
    }

    public function latestPayment()
    {
        return $this->hasOne(Payments::class, 'payer_user_id')
            ->where('status', PaymentStatus::STATUS_COMPLETED)
            ->latest('status_date');
    }
}
