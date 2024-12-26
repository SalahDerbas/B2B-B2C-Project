<?php

namespace App\Http\Controllers\API\V1\b2c\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\API\V1\b2c\Home\HomeResource;
use App\Http\Resources\API\V1\b2c\Home\Item\ItemsResource;
use App\Models\Category;
use App\Models\Item;

class HomeController extends Controller
{

    /**
     * Retrieve and structure the list of categories for the home view.
     *
     * This method fetches all top-level categories (categories without a parent sub-category).
     * If a category matches the 'C-Global' lookup value, it fetches its related items.
     * Otherwise, it fetches its sub-categories.
     *
     * Relationships `getSubCategory` and `getItemSource` are eagerly loaded for items
     * under the 'C-Global' sub-category.
     *
     * @return \Illuminate\Http\JsonResponse The structured categories and their sub-items or sub-categories.
     */
    public function index()
    {
        try{
            $datas = Category::whereNull('sub_category_id')->where('status', 1)->get();
            $globalId = getValueLookups('C-Global');
            foreach ($datas as $data){
                $data->subs = ($data->id == $globalId)
                    ? Item::where(['sub_category_id' => $globalId, 'status' => 1])->with(['getSubCategory' , 'getItemSource'])->get()
                    : Category::where(['sub_category_id' => $data->id , 'status' =>  1])->get();
            }
            return responseSuccess(HomeResource::collection($datas), getStatusText(HOME_SUCCESS_CODE), HOME_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }




    public function search($input)
    {
        try{
            $input = trim( (preg_replace('/[^A-Za-z0-9]/', '',$input)) );
            $itemFields = ['capacity', 'plan_type', 'validaty'];

            $data = Item::where(function ($query) use ($itemFields, $input) {
                    foreach ($itemFields as $field) {
                        $query->orWhere($field, 'LIKE', "%{$input}%");
                    }
                })->where('status', true)->get();

            if ($data->isEmpty())
                return responseSuccess('', getStatusText(SEARCH_NOT_FOUND_CODE), SEARCH_NOT_FOUND_CODE);

                return responseSuccess(ItemsResource::collection($data), getStatusText(SEARCH_SUCCESS_CODE), SEARCH_SUCCESS_CODE);
            } catch (\Exception $e) {
                return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
            }
    }

    public function slider()
    {
        try{
            $data = Item::where(['is_slider' => True, 'status' => True])->get();

            if ($data->isEmpty())
                return responseSuccess('', getStatusText(SLIDER_NOT_FOUND_CODE), SLIDER_NOT_FOUND_CODE);

                return responseSuccess(ItemsResource::collection($data), getStatusText(SLIDER_SUCCESS_CODE), SLIDER_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

}
