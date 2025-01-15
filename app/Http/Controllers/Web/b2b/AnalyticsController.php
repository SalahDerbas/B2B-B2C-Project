<?php

namespace App\Http\Controllers\Web\b2b;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    /**
     * Displays the analytics page.
     *
     * @author Salah Derbas
     * @return \Illuminate\View\View The analytics page view.
     */
    public function index()
    {
        try{
            return view('Web.b2b.Pages.Analytics.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

}
