<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'profile_id',
        'invoice_number',
        'total_amount',
        'total_amount_without_vat',
        'status',
        'service_delivered',
        'payment_way',
        'ipg_gateway_id',
        'ipg_init_refid',
        'ipg_init_temp_data',
        'refid',
        'payment_code',
        'offline_payment_id',
        'vat',
        'promo_code_id',
        'promo_codes_amount',
        'promo_code_registered_data',
        'paid_at',
    ];

    public function profile()
    {
        return $this->belongsTo('App\Profile');
    }

        public function invoiceItems()
    {
        return $this->hasMany('App\InvoiceItem');
    }

    public function paymentGateway()
    {
        return $this->belongsTo("App\PaymentGateway", 'ipg_gateway_id');
    }

    public function offlinePayment()
    {
        return $this->belongsTo('App\OfflinePayment');
    }

    public function affiliationInvoice()
    {
        return $this->hasOne('App\AffiliationInvoice');
    }
}
