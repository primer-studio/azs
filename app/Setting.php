<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'site_title',
        'site_short_title',
        'register_temp_user',
        'user_can_skip_profile_questions',
        'user_must_pay_without_answering_diet_required_questions',
        'user_can_pay_without_answering_diet_required_questions',
        'vat_percentage',
        'vat_visibility_is_invoice',
    ];
}
