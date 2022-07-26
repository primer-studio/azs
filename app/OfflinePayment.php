<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfflinePayment extends Model
{
    const VALID_PAYMENT_TYPES = [
        'card_to_card',
        'deposit_by_bank_receipt',
    ];
    protected $fillable = [
        'profile_id',
        'amount',
        'payment_date',
        'payment_type',
        'tracking_number',
        'card_number',
        'is_verified',
        'verified_at',
        'seen',
        'admin_id'
    ];

    public function profile()
    {
        return $this->belongsTo('App\Profile');
    }

    public function admin()
    {
        return $this->belongsTo('App\Admin');
    }

    public function invoice()
    {
        return $this->hasOne("App\Invoice");
    }
}
