<?php

namespace App\Http\Controllers\Web\b2b;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Displays the home page.
     *
     * @author Salah Derbas
     * @return \Illuminate\View\View The home page view.
     */
    public function index()
    {
        return view('Web.b2b.home');
    }
}
