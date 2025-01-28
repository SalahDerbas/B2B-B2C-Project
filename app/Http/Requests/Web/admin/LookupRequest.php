<?php

namespace App\Http\Requests\Web\admin;

use Illuminate\Foundation\Http\FormRequest;

class LookupRequest extends FormRequest
{
    private const ROUTE_LOOKUP_UPDATE             = 'admin.lookups.update';
    private const ROUTE_LOOKUP_EDIT               = 'admin.lookups.edit';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    /**
     * Get the validation rules for editing an lookup.
     *
     * @author Salah Derbas
     * @return array
     */
    private function editLookupRequest()
    {
        return  [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:lookups,id'] ,
            ],
        ];
    }

    /**
     * Get the validation rules for updating an item.
     *
     * @author Salah Derbas
     * @return array
     */
    private function updateLookupRequest()
    {
        return [
            'rules'   =>  [
                'id'        =>   ['required' , 'exists:lookups,id'] ,
                'value'     =>   ['required'] ,
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
            self::ROUTE_LOOKUP_UPDATE               => $this->updateLookupRequest(),
            self::ROUTE_LOOKUP_EDIT                 => $this->editLookupRequest(),

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
