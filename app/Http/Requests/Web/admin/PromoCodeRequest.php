<?php

namespace App\Http\Requests\Web\admin;

use Illuminate\Foundation\Http\FormRequest;

class PromoCodeRequest extends FormRequest
{
    private const ROUTE_PROMO_CODE_STORE              = 'admin.promo_codes.store';
    private const ROUTE_PROMO_CODE_UPDATE             = 'admin.promo_codes.update';
    private const ROUTE_PROMO_CODE_DELETE             = 'admin.promo_codes.delete';
    private const ROUTE_PROMO_CODE_EDIT               = 'admin.promo_codes.edit';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    /**
     * Get the validation rules for editing an PromoCode.
     *
     * @author Salah Derbas
     * @return array
     */
    private function editPromoCodeRequest()
    {
        return [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:promo_codes,id'] ,
            ],
        ];
    }

    /**
     * Get the validation rules for deleting an PromoCode.
     *
     * @author Salah Derbas
     * @return array
     */
    private function deletePromoCodeRequest()
    {
        return [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:promo_codes,id'] ,
            ],
        ];
    }

    /**
     * Get the validation rules for updating an PromoCode.
     *
     * @author Salah Derbas
     * @return array
     */
    private function updatePromoCodeRequest()
    {
        return [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:promo_codes,id'],
                'promo_code'  =>  ['required'] ,
                'description' =>  ['nullable'] ,
                'limit'       =>  ['required'],
                'user_limit'  =>  ['required'],
                'amount'      =>  ['required'],
                'from_date'   =>  ['required' , 'date'],
                'to_date'     =>  ['required' , 'date'],
                'type_id'     =>  ['required' , 'exists:lookups,id' ],
            ],
        ];
    }

    /**
     * Get the validation rules for storing a new PromoCode.
     *
     * @author Salah Derbas
     * @return array
     */
    private function storePromoCodeRequest()
    {
        return [
            'rules'   =>  [
                'promo_code'  =>  ['required'] ,
                'description' =>  ['nullable'] ,
                'limit'       =>  ['required'],
                'user_limit'  =>  ['required'],
                'amount'      =>  ['required'],
                'from_date'   =>  ['required' , 'date'],
                'to_date'     =>  ['required' , 'date'],
                'type_id'     =>  ['required' , 'exists:lookups,id' ],
            ],
        ];
    }
    /**
     * Get requested data based on the current route.
     *
     * @param string $key
     * @return mixed
     * @author Salah Derbas
     */
    private function requested($key)
    {
        $route = $this->route()->getName();
        $data  = match ($route) {
            self::ROUTE_PROMO_CODE_STORE                => $this->storePromoCodeRequest(),
            self::ROUTE_PROMO_CODE_UPDATE               => $this->updatePromoCodeRequest(),
            self::ROUTE_PROMO_CODE_DELETE               => $this->deletePromoCodeRequest(),
            self::ROUTE_PROMO_CODE_EDIT                 => $this->editPromoCodeRequest(),

                default => [ 'rules' => [], 'messages' => []  ]
        };
        return $data[$key];

    }

    /**
     * Get the validation rules for the request.
     *
     * @return array
     * @author Salah Derbas
     */
    public function rules()
    {
        return $this->requested('rules');
    }


}
