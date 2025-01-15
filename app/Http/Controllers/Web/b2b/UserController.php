<?php

namespace App\Http\Controllers\Web\b2b;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Displays the user profile page.
     *
     * @author Salah Derbas
     * @return \Illuminate\View\View The user profile page view with user data.
     */
    public function index()
    {
        try{
            $user = auth()->user();
            return view('Web.b2b.Pages.User.index' , compact('user'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }
}
