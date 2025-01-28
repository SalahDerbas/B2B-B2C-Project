<?php

namespace App\Http\Controllers\Web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
{
    public function index()
    {
        return view('Web.admin.Pages.promoCodes.index');
    }
}
