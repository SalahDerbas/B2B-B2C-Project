<?php

namespace App\Http\Controllers\Web\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\Web\admin\B2BRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\PaymentPrice;
use App\Models\ItemSource;
use App\Models\Operater;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class B2BController extends Controller
{

    /**
     * Display the list of B2B users.
     *
     * @author Salah Derbas
     */
    public function index()
    {
        try{
            $datas = User::where('type' , 2)->paginate(15);
            return view('Web.admin.Pages.b2bs.index' , compact('datas'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }


    /**
     * Show the form to create a new B2B user.
     *
     * @author Salah Derbas
     */
    public function create()
    {
        try{
            $types = getDataLookups('U-OperatorType');
            return view('Web.admin.Pages.b2bs.create' , compact('types'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }

    }

    /**
     * Store a newly created B2B user in the database.
     *
     * @param B2BRequest $request
     * @author Salah Derbas
     */
    public function store(B2BRequest $request)
    {
        try{
            DB::transaction(function () use ($request) {
                $validated = $request->validated();
                User::create([
                    'usrename'           => $validated['username'],
                    'name'               => $validated['name'],
                    'email'              => $validated['email'],
                    'password'           => Hash::make($validated['password']),
                    'status'             => True,
                    'type'               => 2,
                    'b2b_balance'        => $validated['b2b_balance'],
                    'payment_id'         => $request['payment_id'],
                    'client_id'          => rand(1000000000,10000000000),
                    'client_secret'      => generateString(150),
                    'created_at'         => Carbon::now(),
                    'updated_at'         => Carbon::now(),
                    'email_verified_at'  => Carbon::now(),
                ]);
                $this->addItemsForB2bAccount( $request['payment_id'] );
          });

            toastr()->success('Data Saved Successfully!');
            return redirect()->route('admin.b2bs.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Toggle the status of a B2B user.
     *
     * @param B2BRequest $request
     * @author Salah Derbas
     */
    public function switchStatus(B2BRequest $request)
    {
        try{
            $validated = $request->validated();

            $data = User::findOrFail($validated['id']);
            $data->update(['status' => !$data['status'] ]);

            toastr()->success($data['email'] .' Update Status Successfully!');
            return redirect()->route('admin.b2bs.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Show the form to edit an existing B2B user.
     *
     * @param B2BRequest $request
     * @return \Illuminate\View\View
     * @author Salah Derbas
     */
    public function edit(B2BRequest $request)
    {
        try{
            $validated = $request->validated();
            $data  = User::where('type' , 2)->findOrFail($validated['id']);

            return view('Web.admin.Pages.b2bs.edit' , compact('data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Update an existing B2B user's information.
     *
     * @param B2BRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @author Salah Derbas
     */
    public function update(B2BRequest $request)
    {
        try{
            $validated = $request->validated();
            User::findOrFail($validated['id'])->update([
                'usrename'           => $validated['username'],
                'name'               => $validated['name'],
                'email'              => $validated['email'],
                'password'           => Hash::make($validated['password']),
                'b2b_balance'        => $validated['b2b_balance'],
            ]);

            toastr()->info('Data Updated Successfully!');
            return redirect()->route('admin.b2bs.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Delete an existing B2B user.
     *
     * @param B2BRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     * @author Salah Derbas
     */
    public function delete(B2BRequest $request)
    {
        try{
            $validated = $request->validated();
            User::findOrFail($validated['id'])->delete();

            toastr()->error('Data Deleted Successfully!');
            return redirect()->route('admin.b2bs.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Display the operators for a specific B2B user for editing.
     *
     * @param B2BRequest $request
     * @return \Illuminate\View\View
     * @throws \Exception
     * @author Salah Derbas
     */
    public function editOperaters(B2BRequest $request)
    {
        try{
            $validated = $request->validated();
            $payment_id = User::findOrFail($validated['id'])->payment_id;
            $datas =  Operater::where('payment_id', $payment_id)->with(['getType'])->get();
            $types = getDataLookups('U-OperatorType');

            return view('Web.admin.Pages.b2bs.edit-operaters' , compact('datas' , 'types'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Update the operators for a specific B2B user.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     * @author Salah Derbas
     */
    public function updateOperaters(Request $request)
    {
        try{
                DB::transaction(function () use ($request) {

                $ids      = $request->all()['id'];
                $names    = $request->all()['name'];
                $values   = $request->all()['value'];
                $type_ids = $request->all()['type_id'];


                for($i=0; $i < count($ids); $i++)
                {
                    Operater::findOrFail($ids[$i])->update([
                        'name'      =>  $names[$i],
                        'value'     =>  $values[$i],
                        'type_id'   =>  $type_ids[$i],
                    ]);
                }

                $this->updateItemsForB2bAccount($request['payment_id']);
             });

            toastr()->info('Data Updated Successfully!');
            return redirect()->route('admin.b2bs.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Show the form to create new operators for a specific B2B user.
     *
     * @param B2BRequest $request
     * @return \Illuminate\View\View
     * @throws \Exception
     * @author Salah Derbas
     */
    public function newOperaters(B2BRequest $request)
    {
        try{
            $validated = $request->validated();

            $payment_id = User::findOrFail($validated['id'])->payment_id;
            $types = getDataLookups('U-OperatorType');

            return view('Web.admin.Pages.b2bs.new-operaters' , compact('payment_id' , 'types'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Add a new operator for a specific B2B user.
     *
     * @param B2BRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     * @author Salah Derbas
     */
    public function addOperaters(B2BRequest $request)
    {
        try{
            DB::transaction(function () use ($request) {
                $validated = $request->validated();
                Operater::create($validated);

                $this->updateItemsForB2bAccount($validated['payment_id']);
            });

            toastr()->success('Data Saved Successfully!');
            return redirect()->route('admin.b2bs.index');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Retrieve and display items for a specific B2B user based on their payment ID.
     *
     * @param B2BRequest $request
     * @return \Illuminate\View\View
     * @throws \Exception
     * @author Salah Derbas
     */
    public function getItems(B2BRequest $request)
    {
        try{
            $validated = $request->validated();
            $payment_id = User::findOrFail($validated['id'])->payment_id;

            $datas = Item::when(request()->has('sub_category_id') && request()->sub_category_id, function ($query) {
                return $query->where('sub_category_id', request()->sub_category_id);
            })->with(['getSubCategory'])->withWhereHas('getItemSource.getPaymentPrice' , function ($query) use ($payment_id)  {
                $query->where('payment_id', $payment_id );
            })->orderBy('id', 'desc')->paginate(15);
            $categories = Category::all();

            return view('Web.admin.Pages.b2bs.get-items' , compact('datas' , 'categories'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Add item prices for a B2B account based on operators and their types.
     *
     * @param int $payment_id
     * @return bool
     * @author Salah Derbas
     */
    private function addItemsForB2bAccount($payment_id)
    {
        $fixedID = getIDLookups('OT-fixed');
        $datas = ItemSource::all();
        foreach($datas as $data){

            $operators = Operater::where('payment_id', $payment_id)->get();
            $final_price = (float) $data['cost_price'];

            foreach ($operators as $operator)
                $final_price += ($operator->type_id == $fixedID) ? ($operator->value) : ($operator->value * $final_price);

                PaymentPrice::create([
                    'item_source_id' => $data['id'],
                    'payment_id'     => $payment_id,
                    'final_price'    => $final_price,
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),
                ]);
        }
        return True;
    }

    /**
     * Update item prices for a B2B account based on operators and their types.
     *
     * @param int $payment_id
     * @return bool
     * @author Salah Derbas
     */
    private function updateItemsForB2bAccount($payment_id)
    {
        $fixedID = getIDLookups('OT-fixed');
        $datas = ItemSource::all();
        foreach($datas as $data){

            $operators = Operater::where('payment_id', $payment_id)->get();
            $final_price = (float) $data['cost_price'];

            foreach ($operators as $operator)
                $final_price += ($operator->type_id == $fixedID) ? ($operator->value) : ($operator->value * $final_price);

            PaymentPrice::where(['item_source_id' => $data['id'] , 'payment_id' => $payment_id ])->update([
                'final_price'    => $final_price,
            ]);
        }

        return True;
    }


}
