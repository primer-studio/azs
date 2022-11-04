<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Profile extends Model
{
    use Notifiable;

    // we are using json type for data field, so we can't use $fillable property because that will destroy the dynamic structure
    // because while we are using fillable property we have to add all parts of data (json keys) in fillable
    protected $guarded = [];


    /**
     * get the related user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * auto decode answer_properties for each get data from database
     * @param $value
     * @return mixed
     */
    public function getDataAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * auto decode data_comments for each get data from database
     * @param $value
     * @return mixed
     */
    public function getDataCommentsAttribute($value)
    {
        return json_decode($value);
    }


    public function invoices()
    {
        return $this->hasMany('App\Invoice');
    }


    public function invoiceItems()
    {
        return $this->hasManyThrough('App\InvoiceItem', 'App\Invoice');
    }

    public function offlinePayments()
    {
        return $this->hasMany('App\OfflinePayment');
    }

    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    public function province()
    {
        return $this->belongsTo('App\Province');
    }

    public function affiliationInvoices()
    {
        return $this->hasMany('App\AffiliationInvoice');
    }

    public function cartItems()
    {
        return $this->hasMany('App\CartItem');
    }

    public function profileLogs()
    {
        return $this->hasMany('App\ProfileLog');
    }

    public function profileAssets()
    {
        return $this->hasMany('App\ProfileAssets');
    }

    public function inProgressBy()
    {
        return $this->belongsTo('App\Admin', 'in_progress_by', 'id');
    }

    /**
     * Set the profile's name.
     *
     * @param string $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = convertArabicStringToPersian($value);
    }
}
