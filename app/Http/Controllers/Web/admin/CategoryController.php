<?php

namespace App\Http\Controllers\Web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;

use App\Http\Requests\Web\admin\CategoryRequest;
use App\Exports\CategoryExport;

use Maatwebsite\Excel\Facades\Excel;

class CategoryController extends Controller
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
            $MainCategories = Category::whereNull('sub_category_id')->get();
            $datas = Category::when(request()->has('category_id') && request()->category_id, function ($query) {
                return $query->where('sub_category_id', request()->category_id);
            })->with(['getCategoryApp'])->orderBy('id', 'desc')->paginate(15);

            return view('Web.admin.Pages.categories.index' , compact('datas' , 'MainCategories'));
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
            return view('Web.admin.Pages.categories.create' , compact('categories') );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Store a newly created Category in the database.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request)
    {
        try{
            $validated = $request->validated();
            if($request->file('photo'))
                $photo = CustomizeFileUpload($request->file('photo'), 'store' , 'assets/Category' , NULL);
            if($request->file('cover'))
                $cover = CustomizeFileUpload($request->file('cover'), 'store' , 'assets/Category' , NULL);

            Category::create([
                'name'            =>  $validated['name'],
                'description'     =>  $validated['description'],
                'color'           =>  $validated['color'],
                'sub_category_id' =>  $validated['sub_category_id'],
                'photo'           =>  $photo ?? NULL,
                'cover'           =>  $cover ?? NULL,
            ]);

            toastr()->success('Data Saved Successfully!');
            return redirect()->route('admin.categories.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Switch the status of an Category.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchStatus(CategoryRequest $request)
    {
        try{
            $validated = $request->validated();

            $data = Category::findOrFail($validated['id']);
            $data->update(['status' => !$data['status'] ]);

            toastr()->success($data['name'] .' Update Status Successfully!');
            return redirect()->route('admin.categories.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Show the form for editing an existing Category.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\CategoryRequest $request
     * @return \Illuminate\View\View
     */
    public function edit(CategoryRequest $request)
    {
        try{
            $validated = $request->validated();

            $data = Category::findOrFail($validated['id']);
            $categories = Category::all();

            return view('Web.admin.Pages.categories.edit' , compact('data' , 'categories'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Update the specified Category in the database.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CategoryRequest $request)
    {
        try{
            $validated = $request->validated();

            $data = Category::findOrFail($request->id);
            if($request->file('photo'))
                $validated['photo']  = CustomizeFileUpload($request->file('photo'), 'update' , 'assets/Category' ,  $data['photo']);
            if($request->file('cover'))
                $validated['cover']  = CustomizeFileUpload($request->file('cover'), 'update' , 'assets/Category' ,  $data['cover']);

            $data->update($validated);
            toastr()->info('Data Updated Successfully!');
            return redirect()->route('admin.categories.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Delete the specified Category from the database.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(CategoryRequest $request)
    {
        try{
            $validated = $request->validated();
            Category::findOrFail($validated['id'])->delete();

            toastr()->error('Data Deleted Successfully!');
            return redirect()->route('admin.categories.index');
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
    public function export($category_id= NULL)
    {
        try{
            return Excel::download(new CategoryExport($category_id), getFileName('Categories').'.xlsx');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }

    }

    public function getItems(CategoryRequest $request)
    {
        try{
            $validated = $request->validated();
            $datas = Item::where('sub_category_id', $validated['id'])->with(['getSubCategory' , 'getItemSource.getSource'])->orderBy('id', 'desc')->paginate(15);

            $categories = Category::all();

            return view('Web.admin.Pages.items.index' , compact('datas' , 'categories'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

}
