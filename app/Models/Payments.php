<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $fillable = [
        'cash',
        'time_to_pay',
        'status',
        'status_date',

        'payer_user_id',
        'recipient_user_id'
    ];

    protected $casts = [
        'time_to_pay' => 'datetime',
        'status_date' => 'datetime',
    ];

    public $timestamps = false;

    public function payer()
    {
        return $this->belongsTo(User::class, 'payer_user_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_user_id');
    }
}
