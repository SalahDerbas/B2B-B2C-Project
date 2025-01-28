<?php

namespace App\Http\Controllers\Web\b2b;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;

use App\Http\Resources\Web\b2b\ItemsResource;
use Illuminate\Support\Facades\Auth;

use App\Exports\EsimDataExport;
use App\Exports\EsimExport;

use Maatwebsite\Excel\Facades\Excel;

class ManageEsimController extends Controller
{
    /**
     * Displays a paginated list of eSIM items with optional filtering by category.
     *
     * @author Salah Derbas
     * @return \Illuminate\View\View The manage eSIM page view with filtered items and categories.
     */
    public function index()
    {
        try{
            $categories = Category::all();
            $datas = Item::where(['status' => 1 ])->when(request()->has('category_id') && request()->category_id, function ($query) {
                return $query->where('sub_category_id', request()->category_id);
            })->with(['getSubCategory', 'getItemSource.getPaymentPriceB2b'])->paginate(15);
            return view('Web.b2b.Pages.ManageEsim.index' , compact('datas' , 'categories') );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Exports eSIM data filtered by category.
     *
     * @author Salah Derbas
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse The downloaded Excel file containing the eSIM data.
     */
    public function export()
    {
        try{
            $categoryId = request()->category_id;
            return Excel::download(new EsimDataExport($categoryId), getFileName('esim_data').'.xlsx');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Displays the details of a specific eSIM item.
     *
     * @author Salah Derbas
     * @param int $id The ID of the eSIM item to show.
     * @return \Illuminate\View\View The eSIM item details page view.
     */
    public function showEsim($id)
    {
        try{
            $data = Item::with(['getSubCategory', 'getItemSource.getPaymentPriceB2b'])->findOrFail($id);

            return view('Web.b2b.Pages.ManageEsim.show' , compact('data') );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Exports the data of a specific eSIM item.
     *
     * @author Salah Derbas
     * @param int $id The ID of the eSIM item to export.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse The downloaded Excel file containing the eSIM item data.
     */
    public function exportEsim($id)
    {
        try{
            return Excel::download(new EsimExport($id), getFileName('esim').'.xlsx');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }
}
