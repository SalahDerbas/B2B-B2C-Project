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

            if($response['type'] == "Order")
                return $this->OrderCallBackStatus($response['id']);

            if($response['type'] == "Billing")
                return $this->BillingCallBackStatus($response['id']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Updates the billing status to 'pending' and redirects to the billing page.
     *
     * @author Salah Derbas
     * @param int $id The ID of the billing record.
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse Redirects to the billing page.
     */
    private function BillingCallBackStatus($id)
    {
        updateStatusBilling($id , 'status_id' , getStatusID('U-StatusBilling'   ,'SB-pending' ) , 'B2B-API');
        return redirect()->route('b2b.billing.index');
    }

    /**
     * Updates the order status to 'charged', submits the order, and updates the status accordingly.
     * If submission fails, updates the order status to 'failed'. On success, updates the order with final data.
     *
     * @author Salah Derbas
     * @param int $id The ID of the order.
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse Redirects to either the success or failure callback.
     */
    private function OrderCallBackStatus($id)
    {
        $order = Order::findOrFail($id);
        updateStatusOrder($id , 'status_order' , getStatusID('U-StatusOrder'   ,'SO-charged' ) , 'B2C-API');
        $submitOrder =  $this->sourcePackage->submitOrder($order['item_source_id']);

        if(!$submitOrder['success'] ){
            updateStatusOrder($id, 'status_order' , getStatusID('U-StatusOrder'   ,'SO-failed' ) , 'B2C-API');
            return redirect()->route('order.callBack.failed');
        }

        updateOrderFinal($id , $submitOrder['data'] , 'B2C-API');
        return redirect()->route('order.callBack.success' ,['order_id' =>  encryptWithKey($id , 'B2B-B2C')]);
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
        $order_data = Order::select('order_data' , 'status_order')->findOrFail(decryptWithKey($order_id , 'B2B-B2C'));
        if($order_data['status_order'] != getStatusID('U-StatusOrder'   ,'SO-success' ) )
            return redirect()->route('order.callBack.failed');

        $data       = collect(json_decode($order_data['order_data']));
        return view('Order.success' , compact('data'));
    }

}
