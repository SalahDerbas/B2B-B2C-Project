<?php

namespace App\Interfaces\Payment;

use Illuminate\Http\Request;

interface PaymentGatewayInterface
{

    /**
     * Send a payment request to the payment gateway.
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request containing payment details.
     * @return array The response data indicating the result of the payment attempt.
     */
    public function sendPayment(Request $request , $orderID);



    /**
     * Handle the callback from the payment gateway after a payment attempt.
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request containing the callback data.
     * @return bool Return true if the payment is successfully completed, false otherwise.
     */
    public function callBack(Request $request);



}
