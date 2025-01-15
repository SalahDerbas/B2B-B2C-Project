<?php

namespace App\Http\Controllers\Web\b2b;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Billing;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Resources\Web\b2b\BillingResource;

class BillingController extends Controller
{
    /**
     * Displays a paginated list of billing records with optional filtering by status.
     *
     * @author Salah Derbas
     * @return \Illuminate\View\View The billing page view with filtered billing data.
     */
    public function index()
    {
        try{
            $statuses = getDataLookups('U-StatusBilling');
            $datas = Billing::when(request()->has('status_id') && request()->status_id, function ($query) {
                return $query->where('status_id', request()->status_id);
            })->with(['getUser' , 'getPayment' , 'getStatus'])->orderBy('id', 'DESC')->paginate(15);

            return view('Web.b2b.Pages.Billing.index' , compact('datas' , 'statuses'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Displays the details of a specific billing record.
     *
     * @author Salah Derbas
     * @param int $id The ID of the billing record to show.
     * @return \Illuminate\View\View The billing details page view.
     */
    public function show($id)
    {
        try{
            $data = Billing::with(['getUser' , 'getPayment' , 'getStatus'])->findOrFail($id);
            return view('Web.b2b.Pages.Billing.show' , compact('data') );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Downloads a PDF version of a specific billing record.
     *
     * @author Salah Derbas
     * @param int $id The ID of the billing record to download.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse The downloaded PDF file.
     */
    public function download($id)
    {
        try{
            $data = Billing::with(['getUser' , 'getPayment' , 'getStatus'])->findOrFail($id);
            $pdf  = Pdf::loadView('Web.b2b.Pages.Billing.download', ['data' => new BillingResource($data) ] );
            return $pdf->download('Billing'.$data['number_id'].'.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }
}
