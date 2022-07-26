<?php


namespace App\Libraries\Payment;


interface GatewayInterface
{

    /**
     * some gateways generate data before going to web gate like: authority
     * this is up to each gateway's class to generate them and pass them by getInitializedData()
     * the output of getInitializedData() must be an array which it's keys are columns name in `cart_epayment` table
     * these columns in `cart_epayment` table which is equal to the invoice will be filled by the given values
     * @return array
     */
    public function init();

    /*
     * the operations which navigate the user to web gate
     */
    public function goToWebGate($tid = 'notSet');

    /**
     * manges the returned data from the web gate
     * this method must return an array:
     * [
     *      'result' => 'failed' OR 'successful' | required
     *      'invoice_id' => invoice_id | if result is 'successful'
     * ]
     * @return array
     */
    public function callback();

    /**
     * check returned data from the web gate is valid based on the invoice
     * @return boolean
     */
    public function checkPay();

    /**
     * call gateway's verifyTransaction() after checkPay()
     * @return boolean
     */
    public function verifyTransaction($trans_id = null, $amount = null);

    /**
     * reverse the transaction
     * @return mixed
     */
    public function reverseTransaction();
}
