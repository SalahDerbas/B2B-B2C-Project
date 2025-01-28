<?php

namespace App\Http\Controllers\Web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Http\Requests\Web\admin\PaymentRequest;

class PaymentController extends Controller
{

    /**
     * Display a listing of the payments.
     *
     * @author Salah Derbas
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try{
            $datas = Payment::when(request()->has('is_b2b') && request()->is_b2b, function ($query) {
                return $query->where('is_b2b', request()->is_b2b);
            })->paginate(15);
            return view('Web.admin.Pages.payments.index' , compact('datas'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Show the form for creating a new payment.
     *
     * @author Salah Derbas
     * @return \Illuminate\View\View
     */
    public function create()
    {
        try{
            return view('Web.admin.Pages.payments.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Store a newly created payment in the database.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\PaymentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PaymentRequest $request)
    {
        try{
            $validated = $request->validated();
            if($request->file('photo'))
                $photo = CustomizeFileUpload($request->file('photo'), 'store' , 'assets/Payment' , NULL);

            Payment::create([
                'name'        =>  $validated['name'],
                'is_b2b'      =>  $validated['is_b2b'],
                'photo'       =>  $photo ?? NULL,
            ]);

            toastr()->success('Data Saved Successfully!');
            return redirect()->route('admin.payments.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Switch the status of an payment.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\PaymentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchStatus(PaymentRequest $request)
    {
        try{
            $validated = $request->validated();

            $data = Payment::findOrFail($validated['id']);
            $data->update(['status' => !$data['status'] ]);

            toastr()->success($data['name'] .' Update Status Successfully!');
            return redirect()->route('admin.payments.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Show the form for editing an existing payment.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\PaymentRequest $request
     * @return \Illuminate\View\View
     */
    public function edit(PaymentRequest $request)
    {
        try{
            $validated = $request->validated();

            $data = Payment::findOrFail($validated['id']);
            return view('Web.admin.Pages.payments.edit' , compact('data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Update the specified payment in the database.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\PaymentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PaymentRequest $request)
    {
        try{
            $validated = $request->validated();

            $data = Payment::findOrFail($request->id);
            if($request->file('photo'))
                $validated['photo'] = CustomizeFileUpload($request->file('photo'), 'update' , 'assets/Payment' , $data['photo']);

            $data->update($validated);
            toastr()->info('Data Updated Successfully!');
            return redirect()->route('admin.payments.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Delete the specified payment from the database.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\PaymentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(PaymentRequest $request)
    {
        try{
            $validated = $request->validated();
            Payment::findOrFail($validated['id'])->delete();

            toastr()->error('Data Deleted Successfully!');
            return redirect()->route('admin.payments.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }


}
