<?php

namespace App\Http\Controllers\API\V1\b2c\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\API\V1\b2c\Order\SubmitRequest;
use Symfony\Component\HttpFoundation\Response;

use App\Models\Order;
use App\Http\Resources\API\V1\b2c\Order\OrderResource;
use App\Interfaces\Payment\PaymentGatewayInterface;

class SubmitController extends Controller
{

    /**
    * Constructor to initialize PaymentGateway and SourcePackage interfaces
    * @param PaymentGatewayInterface $paymentGateway - Payment gateway service
    * @author Salah Derbas
    */
    public function __construct(PaymentGatewayInterface $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    /**
    * Process payment for a given request
    * @param SubmitRequest $request - Request containing payment details
    * @return \Illuminate\Http\JsonResponse
    * @author Salah Derbas
    */
    public function pay(SubmitRequest $request)
    {
        try{
            $orderID    = insertOrderInitial($request);
            $response = $this->paymentGateway->sendPayment($request["payment_request"] , $orderID);
            if(!$response['success'])
                return responseSuccess($response['data'], getStatusText(PAYMENT_METHOD_FAILED_CODE)  , PAYMENT_METHOD_FAILED_CODE );

            $data = [ 'url' => $response['data'] , 'order_id' => encryptWithKey($orderID , 'B2B-B2C')];
            return responseSuccess($data , getStatusText(PAYMENT_METHOD_SUCCESS_CODE)  , PAYMENT_METHOD_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
    * Retrieve order data and respond with resource
    * @param SubmitRequest $request - Request containing order data
    * @return JsonResponse - Order data response
    * @author Salah Derbas
    */
    public function orderData(SubmitRequest $request)
    {
        try{
            $data   = collect(json_decode($request['order_data']));
            return responseSuccess( new OrderResource($data) , getStatusText(ORDER_DATA_SUCCESS_CODE)  , ORDER_DATA_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
    * Validate and process a promocode
    * @param SubmitRequest $request - Request containing promocode details
    * @return JsonResponse - Promocode validation response
    * @author Salah Derbas
    */
    public function checkPromocode(SubmitRequest $request)
    {
        try {
            return responseSuccess( ['new_price' => $request["new_price"]] , getStatusText(CHECK_PROMOCODE_SUCCESS_CODE), CHECK_PROMOCODE_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

}
