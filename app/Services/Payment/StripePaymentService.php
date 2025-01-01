<?php

namespace App\Services\Payment;

use App\Interfaces\Payment\PaymentGatewayInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\BaseIntegrationService;
use Illuminate\Support\Facades\Auth;

class StripePaymentService extends BaseIntegrationService implements PaymentGatewayInterface
{

    /**
     * Constructor to initialize the Stripe API key, base URL, and headers.
     */
    protected mixed $api_key;
    public function __construct()
    {
        $this->base_url  =   env("STRIPE_BASE_URL");
        $this->api_key   =   env("STRIPE_SECRET_KEY");
        $this->header    =   [
            'Accept'           =>  'application/json',
            'Content-Type'     =>  'application/x-www-form-urlencoded',
            'Authorization'    =>  'Bearer ' . $this->api_key,
        ];
    }

    /**
     * Sends a payment request to Stripe and returns the result.
     *
     * @param Request $request The incoming HTTP request containing payment details.
     * @return array An array containing success status and redirection URL.
     */
    public function sendPayment($request , $orderID): array
    {
        $data     = $this->formatDataPayment($request , $orderID);

        $response = $this->buildRequest('POST', '/v1/checkout/sessions', $data, 'form_params');

        LoggingFile('B2C-API' , '[sendPayment]---RESPONSE_sendPayment--' ,['ip' => getClientIP() , 'user_id' => Auth::id() , 'orderID' => $orderID, 'data' => $data , 'RESPONSE' => $response->getContent()  ]);

        if($response->getData(true)['success'])
            return ['success' => true, 'data' => $response->getData(true)['data']['url']];

        return ['success' => false,'data'=> NULL];
    }

    /**
     * Handles the callback from Stripe after payment processing.
     *
     * @param Request $request The incoming HTTP request containing callback data.
     * @return array True if the payment was successful, otherwise false.
     */
    public function callBack(Request $request): array
    {
        $orderID = $request->get('orderID');
        $session_id     = $request->get('session_id');

        $response   = $this->buildRequest('GET','/v1/checkout/sessions/'.$session_id);

        LoggingFile('B2C-API' , '[callBack]---RESPONSE_callBack--' ,['ip' => getClientIP() , 'callback_response' => $request->all() , 'orderID' => $orderID , 'session_id' => $session_id , 'response' =>$response  ]);

        if($response->getData(true)['success'] && $response->getData(true)['data']['payment_status'] === 'paid')
            return ['success' => true , 'orderID'  =>  $orderID ];

        return ['success' => false , 'orderID'  =>  $orderID ];

    }

    /**
     * Formats the payment data into the required structure for Stripe.
     *
     * @param Request $request The incoming HTTP request containing payment details.
     * @return array The formatted payment data to be sent to Stripe.
     */
    public function formatDataPayment($request , $orderID): array
    {
        return [
            "success_url" => env("APP_URL").'/webview/order/callback?session_id={CHECKOUT_SESSION_ID}&orderID='. $orderID .'',
            "line_items"  => [
                [
                    "price_data" => [
                        "unit_amount"   => round($request['amount'] * 100),
                        "currency"      => $request['currency'],
                        "product_data"  => [
                            "name"         => "product name",
                            "description"  => "description of product"
                        ],
                    ],
                    "quantity" => 1,
                ],
            ],
            "mode" => "payment",
        ];
    }

}
