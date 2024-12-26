<?php

namespace App\Http\Controllers\API\V1\b2c\Home\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\API\V1\b2c\Home\Category\CategoryRequest;
use App\Http\Resources\API\V1\b2c\Home\Category\SubCategoryResource;
use App\Http\Resources\API\V1\b2c\Home\Category\CategoryResource;
use App\Http\Resources\API\V1\b2c\Home\Item\ItemsResource;

use App\Models\Category;
use App\Models\Item;



class CategoryController extends Controller
{

    /**
     * Display a listing of the main categories.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try{
            $data = Category::whereNull('sub_category_id')->where('status', 1)->get();

            return responseSuccess(CategoryResource::collection($data), getStatusText(GET_CATEGORY_SUCCESS_CODE), GET_CATEGORY_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Show a specific category based on its ID.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try{
            $data = Category::where(['id' => $id , 'status' =>  1])->get();
            if(is_null($data))
                return responseSuccess('' , getStatusText(GET_CATEGORY_EMPTY_CODE), GET_CATEGORY_EMPTY_CODE);
            return responseSuccess(new SubCategoryResource($data), getStatusText(GET_CATEGORY_SUCCESS_CODE), GET_CATEGORY_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Retrieve categories related to the regional sub-category.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRegional()
    {
        $typeId = getValueLookups('C-Regional');
        return $this->fetchCategoriesBySubCategoryId($typeId , 'regional');
    }

    /**
     * Retrieve categories related to the local sub-category.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLocal()
    {
        $typeId = getValueLookups('C-Local');
        return $this->fetchCategoriesBySubCategoryId($typeId, 'local');
    }

    /**
     * Retrieve items related to the global .
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGlobal()
    {
        try {
            $subCategoryId = getValueLookups('C-Global');
            $data = Item::where(['sub_category_id' => $subCategoryId, 'status' => 1])->with(['getSubCategory' , 'getItemSource'])->get();

            if ($data->isEmpty())
                return responseSuccess('' , getStatusText(GET_ITEMS_EMPTY_CODE),GET_ITEMS_EMPTY_CODE);

            return responseSuccess(ItemsResource::collection($data),getStatusText(GET_ITEMS_SUCCESS_CODE),GET_ITEMS_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }


    /**
     * Fetch categories based on a specific sub-category ID.
     *
     * @param int $subCategoryId
     * @param string $type
     * @return \Illuminate\Http\JsonResponse
     */
    private function fetchCategoriesBySubCategoryId($subCategoryId, $type)
    {
        try {
            $data = Category::where(['sub_category_id' => $subCategoryId, 'status' => 1])->get();

            if ($data->isEmpty())
                return responseSuccess('' , getStatusText(GET_CATEGORY_EMPTY_CODE),GET_CATEGORY_EMPTY_CODE);

            return responseSuccess(SubCategoryResource::collection($data),getStatusText(GET_CATEGORY_SUCCESS_CODE),GET_CATEGORY_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }







}
