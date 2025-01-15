<?php

namespace App\Http\Controllers\Web\b2b;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class APIDocumentController extends Controller
{
    /**
     * Displays the API documentation page.
     *
     * @author Salah Derbas
     * @return \Illuminate\View\View The API documentation page view.
     */
    public function index()
    {
        try{
            return view('Web.b2b.Pages.APIDocument.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }
}
