<?php

namespace App\Http\Controllers\API\V1\b2b\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\API\V1\b2b\Order\StatusRequest;
use App\Http\Resources\API\V1\b2b\Order\OrderResource;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class SharePackageController extends Controller
{
    /**
     * Retrieves QR code URL based on order data.
     * @param StatusRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @author Salah Derbas
     */
    public function getQR(StatusRequest $request)
    {
        try{
            $data = collect(json_decode($request->order_data))['sims'][0];
            return responseSuccess(['url' => $data->qrcode_url] , getStatusText(GET_QR_SUCCESS_CODE), GET_QR_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Redeems a QR code and updates the order's share ID.
     * @param StatusRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @author Salah Derbas
     */
    public function reedemQR(StatusRequest $request)
    {
        try{
            Order::findOrFail($request['id'])->update(['share_id' => Auth::id()]);
            $data   = collect(json_decode($request['order_data']));
            return responseSuccess( new OrderResource($data) , getStatusText(ORDER_DATA_SUCCESS_CODE)  , ORDER_DATA_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }
}
