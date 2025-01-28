<?php

namespace App\Http\Controllers\Web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Source;
use App\Http\Requests\Web\admin\SourceRequest;

class SourceController extends Controller
{
    /**
     * Display a listing of the sources.
     *
     * @author Salah Derbas
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try{
            $datas = Source::paginate(15);

            return view('Web.admin.Pages.sources.index' , compact('datas'));
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
            return view('Web.admin.Pages.sources.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Store a newly created payment in the database.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\SourceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SourceRequest $request)
    {
        try{
            $validated = $request->validated();
            if($request->file('photo'))
                $photo = CustomizeFileUpload($request->file('photo'), 'store' , 'assets/Source' , NULL);

            Source::create([
                'name'        =>  $validated['name'],
                'photo'       =>  $photo ?? NULL,
            ]);

            toastr()->success('Data Saved Successfully!');
            return redirect()->route('admin.sources.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Switch the status of an payment.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\SourceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchStatus(SourceRequest $request)
    {
        try{
            $validated = $request->validated();

            $data = Source::findOrFail($validated['id']);
            $data->update(['status' => !$data['status'] ]);

            toastr()->success($data['name'] .' Update Status Successfully!');
            return redirect()->route('admin.sources.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Show the form for editing an existing payment.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\SourceRequest $request
     * @return \Illuminate\View\View
     */
    public function edit(SourceRequest $request)
    {
        try{
            $validated = $request->validated();

            $data = Source::findOrFail($validated['id']);
            return view('Web.admin.Pages.sources.edit' , compact('data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Update the specified payment in the database.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\SourceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SourceRequest $request)
    {
        try{
            $validated = $request->validated();

            $data = Source::findOrFail($request->id);
            if($request->file('photo'))
                $validated['photo'] = CustomizeFileUpload($request->file('photo'), 'update' , 'assets/Source' , $data['photo']);

            $data->update($validated);
            toastr()->info('Data Updated Successfully!');
            return redirect()->route('admin.sources.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Delete the specified payment from the database.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\SourceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(SourceRequest $request)
    {
        try{
            $validated = $request->validated();
            Source::findOrFail($validated['id'])->delete();

            toastr()->error('Data Deleted Successfully!');
            return redirect()->route('admin.sources.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }
}
