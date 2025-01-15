<?php

namespace App\Http\Controllers\Web\b2b;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Output\BufferedOutput;


class RunPostmanController extends Controller
{
    /**
     * Displays the Postman page.
     *
     * @author Salah Derbas
     * @return \Illuminate\View\View The Postman page view.
     */
    public function index()
    {
        try{
            return view('Web.b2b.Pages.Postman.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Downloads the Postman collection file for the specified version.
     *
     * @author Salah Derbas
     * @param string $version The version of the Postman collection to download.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse The downloaded Postman collection file.
     */
    public function download($version)
    {
        try{
            $filePath = public_path('public/Postman/'.$version.'/b2b/B2B_API.postman_collection.json');

            if (file_exists($filePath))
                return response()->download($filePath, 'B2B_API.postman_collection.json');

            return redirect()->route('b2b.run_postman.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }
}
