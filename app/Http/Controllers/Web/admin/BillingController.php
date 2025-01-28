<?php

namespace App\Http\Controllers\Web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Billing;
use App\Models\User;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Resources\Web\b2b\BillingResource;
use App\Http\Requests\Web\admin\BillingRequest;
use Carbon\Carbon;

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

            return view('Web.admin.Pages.billings.index' , compact('datas' , 'statuses'));
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
    public function show(BillingRequest $request)
    {
        try{
            $validated = $request->validated();

            $data = Billing::with(['getUser' , 'getPayment' , 'getStatus'])->findOrFail($validated['id']);
            return view('Web.admin.Pages.billings.show' , compact('data') );
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
    public function download(BillingRequest $request)
    {
        try{
            $validated = $request->validated();

            $data = Billing::with(['getUser' , 'getPayment' , 'getStatus'])->findOrFail($validated['id']);
            $pdf  = Pdf::loadView('Web.b2b.Pages.Billing.download', ['data' => new BillingResource($data) ] );
            return $pdf->download('Billing'.$data['number_id'].'.pdf');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Approve a billing request and update the status and user balance.
     *
     * @author Salah Derbas
     * @param BillingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(BillingRequest $request)
    {
        try{
            $validated = $request->validated();
            $data = Billing::findOrFail($validated['id']);

            $data->update([
                'status_id' => getIDLookups('SB-success') ,
                'due_date'  => Carbon::now()
            ]);

            $user = User::findOrFail($data['user_id']);
            $user->update(['b2b_balance' => $data['amount'] ]);


            toastr()->success($data['number_id'] .' Approve Status Successfully!');
            return redirect()->route('admin.billings.index');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Reject a billing request and update its status.
     *
     * @author Salah Derbas
     * @param BillingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject(BillingRequest $request)
    {
        try{
            $validated = $request->validated();
            $data = Billing::findOrFail($validated['id'])->update([
                'status_id' => getIDLookups('SB-failed'),
                'due_date'  => Carbon::now()
            ]);

            toastr()->success($data['number_id'] .' Reject Status Successfully!');
            return redirect()->route('admin.billings.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

}
