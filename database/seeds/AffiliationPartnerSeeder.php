<?php

use Illuminate\Database\Seeder;

class AffiliationPartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\AffiliationPartner::class, 100)->create()->each(function ($u) {
            for ($i = 1; $i < rand(1, 80); $i++) {
                $u->affiliationInvoices()->save(factory(\App\AffiliationInvoice::class)->make());
            }
        });
    }
}
