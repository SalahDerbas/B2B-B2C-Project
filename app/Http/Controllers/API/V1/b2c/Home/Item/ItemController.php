<?php

namespace App\Http\Controllers\API\V1\b2c\Home\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\API\V1\b2c\Home\Item\ItemsResource;
use App\Http\Resources\API\V1\b2c\Home\Item\ItemResource;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Item;
use App\Models\PaymentPrice;

class ItemController extends Controller
{

    /**
     * Display a listing of items filtered by a specific sub-category ID.
     *
     * This method retrieves all items associated with the given sub-category ID.
     * The items must have a status of 1 to be included in the response.
     * Relationships `getSubCategory` and `getItemSource` are eagerly loaded for optimization.
     *
     * @param int $sub_category_id The ID of the sub-category to filter items.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($sub_category_id)
    {
        try{
            $data = Item::where(['sub_category_id' => $sub_category_id, 'status' => 1])->with(['getSubCategory' , 'getItemSource'])->get();

            if ($data->isEmpty())
                return responseSuccess('' , getStatusText(GET_ITEMS_EMPTY_CODE),GET_ITEMS_EMPTY_CODE);

            return responseSuccess(ItemsResource::collection($data),getStatusText(GET_ITEMS_SUCCESS_CODE),GET_ITEMS_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Display the details of a specific item by its ID.
     *
     * This method retrieves a single item based on the provided ID. The item must have
     * a status of 1 to be returned. Relationships `getSubCategory` and `getItemSource`
     * are eagerly loaded to include relevant data.
     *
     * @param int $id The ID of the item to retrieve.
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try{
            $data = Item::where(['id' => $id, 'status' => 1])->with(['getSubCategory' , 'getItemSource' , 'getItemSource.getPaymentPrice' ,  'getItemSource.getPaymentPrice.getPayment'])->first();
            if (is_null($data))
                return responseSuccess('' , getStatusText(GET_ITEMS_EMPTY_CODE),GET_ITEMS_EMPTY_CODE);
            // return $data;

            return responseSuccess(new ItemResource($data),getStatusText(GET_ITEMS_SUCCESS_CODE),GET_ITEMS_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

}
