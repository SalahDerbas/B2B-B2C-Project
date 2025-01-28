<?php

namespace App\Http\Controllers\Web\b2b;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Exports\OrderExport;
use App\Exports\OrdersExport;

use Maatwebsite\Excel\Facades\Excel;

class APIOrderController extends Controller
{
    /**
     * Displays a paginated list of orders filtered by user and status.
     *
     * @author Salah Derbas
     * @return \Illuminate\View\View The API order page view with filtered orders.
     */
    public function index()
    {
        try{
            $statusOrders   = getDataLookups('U-StatusOrder');
            $statusPackages = getDataLookups('U-StatusPackage');

                $user  = User::findOrFail(Auth::id());
                $datas = Order::where(['user_id' =>  $user['id'] , 'payment_id' => $user['payment_id'] ])
                ->when(request()->has('status_order_id') && request()->status_order_id, function ($query) {
                    return $query->where('status_order', request()->status_order_id);
                })->when(request()->has('status_package_id') && request()->status_package_id, function ($query) {
                    return $query->where('status_package', request()->status_package_id);
                })->with(['getUser' ,'getItem' ,'getStatusOrder' ,'getStatusPackage' ,'getCategory'])->paginate(15);

            return view('Web.b2b.Pages.APIOrder.index' , compact('datas' , 'statusOrders' , 'statusPackages'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Displays the details of a specific order.
     *
     * @author Salah Derbas
     * @param int $id The ID of the order to show.
     * @return \Illuminate\View\View The order details page view.
     */
    public function show($id)
    {
        try{
            $data = Order::with(['getUser' ,'getItem' ,'getStatusOrder' ,'getStatusPackage' ,'getCategory'])->findOrFail($id);
            return view('Web.b2b.Pages.APIOrder.show' , compact('data') );
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Exports order data for a specific order.
     *
     * @author Salah Derbas
     * @param int $id The ID of the order to export.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse The downloaded Excel file containing the order data.
     */
    public function exportOrder($id)
    {
        try{
            return Excel::download(new OrderExport($id), getFileName('order_data').'.xlsx');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }

    /**
     * Exports a list of orders based on the selected status filters.
     *
     * @author Salah Derbas
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse The downloaded Excel file containing the filtered orders data.
     */
    public function export()
    {
        try{
            $status_order_id   = request()->status_order_id;
            $status_package_id = request()->status_package_id;

            return Excel::download(new OrdersExport($status_order_id , $status_package_id), getFileName('orders').'.xlsx');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage() );
        }
    }
}
