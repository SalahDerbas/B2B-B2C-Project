<?php

namespace App\Http\Controllers\API\V1\b2b\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\API\V1\b2b\Order\SubmitRequest;
use App\Http\Resources\API\V1\b2b\Order\OrderResource;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Interfaces\Source\SourcePackageInterface;

class SubmitController extends Controller
{

    /**
    * Constructor to initialize SourcePackage interfaces
    * @param SourcePackageInterface $sourcePackage   - Source package service
    * @author Salah Derbas
    */
    public function __construct( SourcePackageInterface $sourcePackage )
    {
        $this->sourcePackage  = $sourcePackage;
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
            User::findOrFail(Auth::id())->update(['b2b_balance' => $request['new_balance']]);
            $orderID    = insertOrderInitial($request , 'B2B-API');

            updateStatusOrder($orderID , 'status_order' , getStatusID('U-StatusOrder'   ,'SO-charged' ) , 'B2B-API');
            $submitOrder =  $this->sourcePackage->submitOrder( $request['item_source_id'] );

            $data  = ['order_id' =>  encryptWithKey( $orderID , 'B2B-B2C')];
            if($submitOrder['success'] ){
                updateStatusOrder($orderID , 'status_order' , getStatusID('U-StatusOrder'   ,'SO-failed' ) , 'B2B-API');
                return responseSuccess( $data , getStatusText(PAY_SUBMIT_FAILED_CODE)  , PAY_SUBMIT_FAILED_CODE );
            }

            updateOrderFinal($orderID , $submitOrder['data'] , 'B2B-API');
            return responseSuccess( $data, getStatusText(PAY_SUBMIT_SUCCESS_CODE)  , PAY_SUBMIT_SUCCESS_CODE );

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



}
