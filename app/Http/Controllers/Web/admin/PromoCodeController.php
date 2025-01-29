<?php

namespace App\Http\Controllers\Web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PromoCode;
use App\Http\Requests\Web\admin\PromoCodeRequest;

class PromoCodeController extends Controller
{
    public function index()
    {
        try{
            $datas = PromoCode::when(request()->has('type_id') && request()->type_id, function ($query) {
                return $query->where('type_id', request()->type_id);
            })->with(['getType'])->paginate(15);
            $types = getDataLookups('U-PromocodeType');

            return view('Web.admin.Pages.promoCodes.index' , compact('datas' , 'types'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Show the form for creating a new PromoCode.
     *
     * @author Salah Derbas
     * @return \Illuminate\View\View
     */
    public function create()
    {
        try{
            $types = getDataLookups('U-PromocodeType');

            return view('Web.admin.Pages.promoCodes.create' , compact('types'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Store a newly created PromoCode in the database.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\PromoCodeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PromoCodeRequest $request)
    {
        try{
            $validated = $request->validated();

            PromoCode::create($validated);

            toastr()->success('Data Saved Successfully!');
            return redirect()->route('admin.promo_codes.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Show the form for editing an existing PromoCode.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\PromoCodeRequest $request
     * @return \Illuminate\View\View
     */
    public function edit(PromoCodeRequest $request)
    {
        try{
            $validated = $request->validated();
            $data = PromoCode::findOrFail($validated['id']);
            $types = getDataLookups('U-PromocodeType');

            return view('Web.admin.Pages.promoCodes.edit' , compact('data' , 'types'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Update the specified PromoCode in the database.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\PromoCodeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PromoCodeRequest $request)
    {
        try{
            $validated = $request->validated();

            PromoCode::findOrFail($validated['id'])->update($validated);

            toastr()->info('Data Updated Successfully!');
            return redirect()->route('admin.promo_codes.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Delete the specified PromoCode from the database.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\PromoCodeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(PromoCodeRequest $request)
    {
        try{
            $validated = $request->validated();
            PromoCode::findOrFail($validated['id'])->delete();

            toastr()->error('Data Deleted Successfully!');
            return redirect()->route('admin.promo_codes.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }



}
