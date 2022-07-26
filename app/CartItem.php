<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Yadakhov\InsertOnDuplicateKey;

class CartItem extends Model
{
    use InsertOnDuplicateKey;
    protected $guarded = [];
    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'U';

    public function diet()
    {
        return $this->belongsTo('App\Diet');
    }

    public function profile()
    {
        return $this->belongsTo('App\Profile');
    }
}
