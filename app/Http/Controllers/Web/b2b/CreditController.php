<?php

namespace App\Http\Controllers\Web\b2b;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Http\Requests\Web\b2b\CreditRequest;
use App\Interfaces\Payment\PaymentGatewayInterface;
use App\Models\Billing;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CreditController extends Controller
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
     * Displays a list of payments for non-B2B and active statuses.
     *
     * @author Salah Derbas
     * @return \Illuminate\View\View The credit page view with payment data.
     */
    public function index()
    {
        try{
            $datas = Payment::where(['status' => true , 'is_b2b' => false])->get();
            return view('Web.b2b.Pages.Credit.index' , compact('datas'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Processes a credit request and initiates the payment gateway process.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\CreditRequest $request The incoming credit request data.
     * @return \Illuminate\Http\RedirectResponse Redirects based on the payment gateway response or with errors.
     */
    public function store(CreditRequest $request)
    {
        try{
            $BillingID = Billing::insertGetId([
                'number_id'         =>  getNumberID('INVO'),
                'issue_date'        =>  Carbon::now(),
                'due_date'          =>  NULL ,
                'amount'            =>  $request['amount'],
                'user_id'           =>  Auth::id(),
                'status_id'         =>  getIDLookups('SB-start_payment'),
                'payment_id'        =>  $request['payment_id'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);


            $response = $this->paymentGateway->sendPayment($request["payment_request"] , $BillingID , 'Billing');

            if(!$response['success'])
                return redirect()->back()->withErrors($response['data']);

            return redirect()->away($response['data']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }
}
