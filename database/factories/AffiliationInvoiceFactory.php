<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\AffiliationInvoice::class, function (Faker $faker) {
    $profiles = \App\Profile::get();
    $invoices = \App\Invoice::get();
    $commission_amounts = [
      '2000',
      '500000',
      '900',
      '10000',
      '900',
      '80000',
      '7000',
      '1000',
      '2000',
    ];
    return [
        'total_amount' => collect($commission_amounts)->random() * 100,
        'profile_id' => $profiles->random()->id,
        'invoice_id' => $invoices->random()->id,
        'commission_rate' => rand(1,100),
        'commission_amount' => collect($commission_amounts)->random(),
        'status' => 'created',
    ];
});
