<?php

namespace App\Http\Controllers\API\Lookup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lookup;

class LookupController extends Controller
{
    /**
     * Get the All Countries for Key and Value.
     *
     * @return \Illuminate\Http\JsonResponse The JSON response with All Countries for Key and Value.
     * @author Salah Derbas
     */
    public function countries()
    {
        try{
            $data = Lookup::where(['code' => 'U-Country' ])->select( 'key' , 'value')->get();
            return responseSuccess($data, getStatusText(COUNTRIES_SUCCESS_CODE), COUNTRIES_SUCCESS_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }



}
