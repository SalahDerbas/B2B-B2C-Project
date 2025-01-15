<?php

namespace App\Http\Controllers\Web\b2b;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class APIIntegrationController extends Controller
{
    /**
     * Displays the API integration page with the user's client credentials.
     *
     * @author Salah Derbas
     * @return \Illuminate\View\View The API integration page view with user-specific data.
     */
    public function index()
    {
        try{
            $data = User::select('client_id' , 'client_secret')->findOrFail(Auth::id());
            return view('Web.b2b.Pages.APIIntegration.index' , compact('data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }
}
