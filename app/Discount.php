<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'title',
        'hash',
        'type',
        'amount',
        'is_active',
        'is_otu',

    ];
}
