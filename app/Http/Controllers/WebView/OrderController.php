<?php

namespace App\Http\Controllers\WebView;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Interfaces\Payment\PaymentGatewayInterface;
use App\Interfaces\Source\SourcePackageInterface;
use App\Models\Order;

class OrderController extends Controller
{
    /**
    * Constructor to initialize PaymentGateway and SourcePackage interfaces
    * @param PaymentGatewayInterface $paymentGateway - Payment gateway service
    * @param SourcePackageInterface $sourcePackage   - Source package service
    * @author Salah Derbas
    */
    public function __construct(PaymentGatewayInterface $paymentGateway , SourcePackageInterface $sourcePackage)
    {
        $this->paymentGateway = $paymentGateway;
        $this->sourcePackage  = $sourcePackage;
    }

    /**
    * Handle payment callback and order status updates
    * @param Request $request - Request containing callback details
    * @return RedirectResponse - Redirect to success or failure page
    * @return \Illuminate\Http\JsonResponse
    * @author Salah Derbas
    */
    public function callBack(Request $request )
    {
        try{
            $response = $this->paymentGateway->callBack($request);
            if (!$response['success'])
                return redirect()->route('order.callBack.failed');

            $order = Order::findOrFail($response['orderID']);
            updateStatusOrder($response['orderID'] , 'status_order' , getStatusID('U-StatusOrder'   ,'SO-charged' ) , 'B2C-API');
            $submitOrder =  $this->sourcePackage->submitOrder($order['item_source_id']);

            if(!$submitOrder['success'] ){
                updateStatusOrder($response['orderID'] , 'status_order' , getStatusID('U-StatusOrder'   ,'SO-failed' ) , 'B2C-API');
                return redirect()->route('order.callBack.failed');
            }

            updateOrderFinal($response['orderID'] , $submitOrder['data'] , 'B2C-API');
            return redirect()->route('order.callBack.success' ,['order_id' =>  encryptWithKey($response['orderID'] , 'B2B-B2C')]);

        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
    * Display the failed payment page
    * @return View - Failed payment page view
    * @return \Illuminate\Http\JsonResponse
    * @author Salah Derbas
    */
    public function failedPage()
    {
        return view('Order.failed');

    }

    /**
    * Display the success payment page with order details
    * @param string $order_id - Encrypted order ID
    * @return View - Success payment page view
    * @author Salah Derbas
    */
    public function successPage(string $order_id)
    {
        $order_data = Order::select('order_data')->findOrFail(decryptWithKey($order_id , 'B2B-B2C'));
        $data       = collect(json_decode($order_data['order_data']));

        return view('Order.success' , compact('data'));
    }


}
