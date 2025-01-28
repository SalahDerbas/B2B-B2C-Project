<?php

namespace App\Http\Requests\Web\admin;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
    private const ROUTE_COUNTRY_STORE              = 'admin.countries.store';
    private const ROUTE_COUNTRY_UPDATE             = 'admin.countries.update';
    private const ROUTE_COUNTRY_DELETE             = 'admin.countries.delete';
    private const ROUTE_COUNTRY_EDIT               = 'admin.countries.edit';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    /**
     * Get the validation rules for editing an source.
     *
     * @author Salah Derbas
     * @return array
     */
    private function editCountryRequest()
    {
        return [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:countries,id'] ,
            ],
        ];
    }

    /**
     * Get the validation rules for deleting an source.
     *
     * @author Salah Derbas
     * @return array
     */
    private function deleteCountryRequest()
    {
        return [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:countries,id'] ,
            ],
        ];
    }

    /**
     * Get the validation rules for updating an source.
     *
     * @author Salah Derbas
     * @return array
     */
    private function updateCountryRequest()
    {
        return [
            'rules'   =>  [
                'name_en'          =>  ['required'] ,
                'name_ar'          =>  ['required'] ,
                'code'             =>  ['required'] ,
            ],
        ];
    }

    /**
     * Get the validation rules for storing a new source.
     *
     * @author Salah Derbas
     * @return array
     */
    private function storeCountryRequest()
    {
        return [
            'rules'   =>  [
                'name_en'          =>  ['required'] ,
                'name_ar'          =>  ['required'] ,
                'code'             =>  ['required'] ,
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
            self::ROUTE_COUNTRY_STORE                => $this->storeCountryRequest(),
            self::ROUTE_COUNTRY_UPDATE               => $this->updateCountryRequest(),
            self::ROUTE_COUNTRY_DELETE               => $this->deleteCountryRequest(),
            self::ROUTE_COUNTRY_EDIT                 => $this->editCountryRequest(),

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
