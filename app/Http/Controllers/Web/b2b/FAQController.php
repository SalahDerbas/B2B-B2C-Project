<?php

namespace App\Http\Controllers\Web\b2b;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FAQController extends Controller
{
    /**
     * Displays the help page.
     *
     * @author Salah Derbas
     * @return \Illuminate\View\View The help page view.
     */
    public function index()
    {
        try{
            return view('Web.b2b.Pages.Help.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }
}
