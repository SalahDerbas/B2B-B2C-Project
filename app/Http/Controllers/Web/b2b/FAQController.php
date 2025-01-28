<?php

namespace App\Http\Controllers\Web\b2b;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lookup;

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
            $datas =  Lookup::where(['code' => 'U-FAQ-b2b'])->pluck('value')->map(fn($data) => json_decode($data, true))->filter()->values();
            return view('Web.b2b.Pages.Help.index' , compact('datas') );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }
}
