<?php

namespace App\Http\Controllers\Web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lookup;
use App\Http\Requests\Web\admin\LookupRequest;

class LookupController extends Controller
{

    /**
     * Display a listing of the Lookups.
     *
     * @author Salah Derbas
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            $filters = request()->only(['code', 'key']);
            $datas   = Lookup::when(isset($filters['code']), fn($query) => $query->where('code', $filters['code']))
                             ->when(isset($filters['key']),  fn($query) => $query->where('key',  $filters['key']))
                             ->orderByDesc('id')->paginate(15);

            $keys  = Lookup::distinct('key')->pluck('key');
            $codes = Lookup::distinct('code')->pluck('code');

            return view('Web.admin.Pages.lookups.index', compact('datas', 'codes', 'keys'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

        /**
     * Show the form for editing an existing Category.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\LookupRequest $request
     * @return \Illuminate\View\View
     */
    public function edit(LookupRequest $request)
    {
        try{
            $validated = $request->validated();

            $data = Lookup::findOrFail($validated['id'])
            ;
            return view('Web.admin.Pages.lookups.edit' , compact( 'data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Update the specified Category in the database.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\LookupRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(LookupRequest $request)
    {
        try{
            $validated = $request->validated();

            $data = Lookup::findOrFail($request->id)->update([
                'value'    =>  $validated['value'],
            ]);

            toastr()->info('Data Updated Successfully!');
            return redirect()->route('admin.lookups.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

}
