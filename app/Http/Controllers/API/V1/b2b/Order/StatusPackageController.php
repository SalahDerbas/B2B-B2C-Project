<?php

namespace App\Http\Controllers\API\V1\b2b\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Http\Resources\API\V1\b2b\Order\PackagesResouce;
use App\Http\Resources\API\V1\b2b\Order\UsageResouce;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\API\V1\b2b\Order\StatusRequest;
use App\Interfaces\Source\SourcePackageInterface;

class StatusPackageController extends Controller
{
    /**
     * Constructor: Initializes the class with the provided source package.
     * @param SourcePackageInterface $sourcePackage
     * @author Salah Derbas
     */
    public function __construct(SourcePackageInterface $sourcePackage)
    {
        $this->sourcePackage  = $sourcePackage;
    }

    /**
     * Fetches and processes user orders with detailed relations.
     * @return \Illuminate\Http\JsonResponse
     * @author Salah Derbas
     */
    public function index()
    {
        try{
            $statusOrderID = getStatusID('U-StatusOrder'   ,'SO-success' );
            $data = Order::whereNotNull('order_data')->where(['status_order' => $statusOrderID , 'user_id' => Auth::id() ])
            ->select('order_data' , 'status_package' , 'item_source_id' , 'iccid')
            ->with(['getItemSource.getItem' , 'getItemSource.getItem.getSubCategory'])->get()
            ->map(fn($item) => [ 'order_data'  =>  collect(json_decode($item->order_data)) , 'status_package' => $item->status_package , 'iccid' => $item->iccid , 'getItem' => $item->getItemSource->getItem , 'getSubCategory' => $item->getItemSource->getItem->getSubCategory ]);

            if ($data->isEmpty())
                return responseSuccess('' , getStatusText(PACKAGES_EMPTY_CODE),PACKAGES_EMPTY_CODE);

            return responseSuccess(PackagesResouce::collection($data) , getStatusText(PACKAGES_SUCCESS_CODE), PACKAGES_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Retrieves package usage information based on the given ICCID.
     * @param StatusRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @author Salah Derbas
     */
    public function usage(StatusRequest $request)
    {
        try{
            $data = Order::with(['getItemSource.getItem' , 'getItemSource.getItem.getSubCategory'])->where(['iccid' => $request->iccid , 'user_id' => Auth::id() ])->select('item_source_id')->first();

            $response = $this->sourcePackage->usagePackage($request->iccid);
            if(!$response['success'])
                return responseSuccess('', getStatusText(USAGE_PACKAGE_FAILED_CODE)  , USAGE_PACKAGE_FAILED_CODE );

            $data['usagePackage'] = $response['data'];
            return responseSuccess(new UsageResouce($data) , getStatusText(USAGE_PACKAGE_SUCCESS_CODE), USAGE_PACKAGE_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

}
