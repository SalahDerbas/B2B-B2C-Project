<?php

namespace App\Http\Controllers\API\V1\b2b\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\API\V1\b2c\Home\Item\ItemsResource;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Item;

class HomeController extends Controller
{

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
}
