<?php

namespace App\Http\Controllers\Web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Source;
use App\Models\Category;
use App\Models\ItemSource;
use App\Models\Country;

use App\Http\Requests\Web\admin\ItemRequest;
use Carbon\Carbon;

use App\Exports\ItemExport;
use Maatwebsite\Excel\Facades\Excel;

class ItemController extends Controller
{
    /**
     * Display a listing of the Categories.
     *
     * @author Salah Derbas
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try{
            $datas = Item::when(request()->has('sub_category_id') && request()->sub_category_id, function ($query) {
                return $query->where('sub_category_id', request()->sub_category_id);
            })->with(['getSubCategory' , 'getItemSource.getSource'])->orderBy('id', 'desc')->paginate(15);

            $categories = Category::all();

            return view('Web.admin.Pages.items.index' , compact('datas' , 'categories'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    public function show(ItemRequest $request)
    {
        try{
            $validated = $request->validated();
            $data = Item::with(['getSubCategory' , 'getItemSource.getSource'])->findOrFail($validated['id']);

            return view('Web.admin.Pages.items.show' , compact('data') );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Show the form for creating a new Category.
     *
     * @author Salah Derbas
     * @return \Illuminate\View\View
     */
    public function create()
    {
        try{
            $categories = Category::all();
            $sources    = Source::all();
            $countries = Country::all();
            return view('Web.admin.Pages.items.create' , compact('categories' , 'sources' , 'countries') );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Store a newly created Category in the database.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\ItemRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ItemRequest $request)
    {
        try{
            $validated = $request->validated();

            $item_id = Item::insertGetId([
                'capacity'          =>  $validated['capacity'],
                'plan_type'         =>  $validated['plan_type'],
                'validaty'          =>  $validated['validaty'],
                'sub_category_id'   =>  $validated['sub_category_id'],
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);
            ItemSource::insert([
                'package_id'        =>  $validated['package_id'],
                'cost_price'        =>  (float)$validated['cost_price'],
                'retail_price'      =>  (float)$validated['retail_price'],
                'source_id'         =>  $validated['source_id'],
                'item_id'           =>  $item_id,
                'created_at'        =>  Carbon::now(),
                'updated_at'        =>  Carbon::now()
            ]);

            toastr()->success('Data Saved Successfully!');
            return redirect()->route('admin.items.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Switch the status of an Category.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\ItemRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchStatus(ItemRequest $request)
    {
        try{
            $validated = $request->validated();

            $data = Item::findOrFail($validated['id']);
            $data->update(['status' => !$data['status'] ]);

            toastr()->success($data['name'] .' Update Status Successfully!');
            return redirect()->route('admin.items.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Switch the slider of an Item.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\ItemRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchSlider(ItemRequest $request)
    {
        try{
            $validated = $request->validated();

            $data = Item::findOrFail($validated['id']);
            $data->update(['is_slider' => !$data['is_slider'] ]);

            toastr()->success($data['name'] .' Update Slider Successfully!');
            return redirect()->route('admin.items.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }

    }
    /**
     * Show the form for editing an existing Category.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\ItemRequest $request
     * @return \Illuminate\View\View
     */
    public function edit(ItemRequest $request)
    {
        try{
            $validated = $request->validated();

            $data = Item::with(['getSubCategory' , 'getItemSource.getSource'])->findOrFail($validated['id']);

            $categories  = Category::all();
            $sources     = Source::all();
            $countries   = Country::all();

            return view('Web.admin.Pages.items.edit' , compact( 'data','categories' , 'sources' , 'countries'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Update the specified Category in the database.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\ItemRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ItemRequest $request)
    {
        try{
            $validated = $request->validated();

            $data = Item::with(['getItemSource'])->findOrFail($request->id);

            $data->update([
                'capacity'          =>  $validated['capacity'],
                'plan_type'         =>  $validated['plan_type'],
                'validaty'          =>  $validated['validaty'],
                'sub_category_id'   =>  $validated['sub_category_id'],
            ]);

            ItemSource::findOrFail($data['getItemSource']['id'])->update([
                'package_id'        =>  $validated['package_id'],
                'cost_price'        =>  (float)$validated['cost_price'],
                'retail_price'      =>  (float)$validated['retail_price'],
                'source_id'         =>  $validated['source_id'],
            ]);

            toastr()->info('Data Updated Successfully!');
            return redirect()->route('admin.items.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Delete the specified Category from the database.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\ItemRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(ItemRequest $request)
    {
        try{
            $validated = $request->validated();
            Item::findOrFail($validated['id'])->delete();

            toastr()->error('Data Deleted Successfully!');
            return redirect()->route('admin.items.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Exports the data of a specific Category item.
     *
     * @author Salah Derbas
     * @param int $id The ID of the Category item to export.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse The downloaded Excel file containing the Category data.
     */
    public function export($sub_category_id= NULL)
    {
        try{
            return Excel::download(new ItemExport($sub_category_id), getFileName('Items').'.xlsx');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }

    }
}
