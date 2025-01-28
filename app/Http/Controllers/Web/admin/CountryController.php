<?php

namespace App\Http\Controllers\Web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Http\Requests\Web\admin\CountryRequest;

class CountryController extends Controller
{

    /**
     * Display a listing of the countries.
     *
     * @author Salah Derbas
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try{
            $datas = Country::orderBy('id', 'desc')->paginate(15);

            return view('Web.admin.Pages.countries.index' , compact('datas'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Show the form for creating a new country.
     *
     * @author Salah Derbas
     * @return \Illuminate\View\View
     */
    public function create()
    {
        try{
            return view('Web.admin.Pages.countries.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Store a newly created country in the database.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\CountryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CountryRequest $request)
    {
        try{
            $validated = $request->validated();
            if($request->file('photo'))
                $photo = CustomizeFileUpload($request->file('photo'), 'store' , 'assets/Flags' , NULL);

            Country::create([
                'name_en'    =>  $validated['name_en'],
                'name_ar'    =>  $validated['name_ar'],
                'code'       =>  $validated['code'],
                'flag'       =>  $photo ?? NULL,
            ]);

            toastr()->success('Data Saved Successfully!');
            return redirect()->route('admin.countries.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }


    /**
     * Show the form for editing an existing payment.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\CountryRequest $request
     * @return \Illuminate\View\View
     */
    public function edit(CountryRequest $request)
    {
        try{
            $validated = $request->validated();

            $data = Country::findOrFail($validated['id']);
            return view('Web.admin.Pages.countries.edit' , compact('data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Update the specified payment in the database.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\CountryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CountryRequest $request)
    {
        try{
            $validated = $request->validated();

            $data = Country::findOrFail($request->id);
            if($request->file('photo'))
                $validated['flag'] = CustomizeFileUpload($request->file('photo'), 'update' , 'assets/Flags' , $data['flag']);

            $data->update($validated);
            toastr()->info('Data Updated Successfully!');
            return redirect()->route('admin.countries.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Delete the specified payment from the database.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\CountryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(CountryRequest $request)
    {
        try{
            $validated = $request->validated();
            Country::findOrFail($validated['id'])->delete();

            toastr()->error('Data Deleted Successfully!');
            return redirect()->route('admin.countries.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }
}
