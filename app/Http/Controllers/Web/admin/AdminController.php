<?php

namespace App\Http\Controllers\Web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Http\Requests\Web\admin\AdminRequest;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    /**
     * Display a listing of the admins.
     *
     * @author Salah Derbas
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try{
            $datas = Admin::paginate(15);
            return view('Web.admin.Pages.admins.index' , compact('datas'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Show the form for creating a new admin.
     *
     * @author Salah Derbas
     * @return \Illuminate\View\View
     */
    public function create()
    {
        try{
            return view('Web.admin.Pages.admins.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Store a newly created admin in the database.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\AdminRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AdminRequest $request)
    {
        try{
            $validated = $request->validated();

            Admin::create([
                'username'   =>  $validated['username'],
                'email'      =>  $validated['email'],
                'password'   =>  Hash::make($validated['password']),
            ]);

            toastr()->success('Data Saved Successfully!');
            return redirect()->route('admin.admins.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Switch the status of an admin.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\AdminRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchStatus(AdminRequest $request)
    {
        try{
            $validated = $request->validated();

            $data = Admin::findOrFail($validated['id']);
            $data->update(['status' => !$data['status'] ]);

            toastr()->success($data['email'] .' Update Status Successfully!');
            return redirect()->route('admin.admins.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Show the form for editing an existing admin.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\AdminRequest $request
     * @return \Illuminate\View\View
     */
    public function edit(AdminRequest $request)
    {
        try{
            $validated = $request->validated();

            $data = Admin::findOrFail($validated['id']);
            return view('Web.admin.Pages.admins.edit' , compact('data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Update the specified admin in the database.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\AdminRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AdminRequest $request)
    {
        try{
            $validated = $request->validated();
            Admin::findOrFail($request->id)->update([
                'username'   =>  $request->username,
                'email'      =>  $request->email,
                'password'   =>  Hash::make($request->password),
            ]);

            toastr()->info('Data Updated Successfully!');
            return redirect()->route('admin.admins.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Delete the specified admin from the database.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\AdminRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(AdminRequest $request)
    {
        try{
            $validated = $request->validated();
            Admin::findOrFail($validated['id'])->delete();

            toastr()->error('Data Deleted Successfully!');
            return redirect()->route('admin.admins.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }
}
