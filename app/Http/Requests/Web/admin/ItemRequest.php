<?php

namespace App\Http\Requests\Web\admin;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{
    private const ROUTE_ITEM_STORE              = 'admin.items.store';
    private const ROUTE_ITEM_SHOW               = 'admin.items.show';
    private const ROUTE_ITEM_UPDATE             = 'admin.items.update';
    private const ROUTE_ITEM_DELETE             = 'admin.items.delete';
    private const ROUTE_ITEM_EDIT               = 'admin.items.edit';
    private const ROUTE_ITEM_SWITCH_STATUS      = 'admin.items.switchStatus';
    private const ROUTE_ITEM_SWITCH_SLIDER      = 'admin.items.switchSlider';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules for switching the item status.
     *
     * @author Salah Derbas
     * @return array
     */
    private function showItemRequest()
    {
        return [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:items,id'] ,
            ],
        ];
    }

    /**
     * Get the validation rules for switching the item status.
     *
     * @author Salah Derbas
     * @return array
     */
    private function switchStatusItemRequest()
    {
        return [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:items,id'] ,
            ],
        ];
    }

    /**
     * Get the validation rules for switching the item slider.
     *
     * @author Salah Derbas
     * @return array
     */
    private function switchSliderItemRequest()
    {
        return [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:items,id'] ,
            ],
        ];
    }

    /**
     * Get the validation rules for editing an item.
     *
     * @author Salah Derbas
     * @return array
     */
    private function editItemRequest()
    {
        return [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:items,id'] ,
            ],
        ];
    }

    /**
     * Get the validation rules for deleting an item.
     *
     * @author Salah Derbas
     * @return array
     */
    private function deleteItemRequest()
    {
        return [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:items,id'] ,
            ],
        ];
    }

    /**
     * Get the validation rules for updating an item.
     *
     * @author Salah Derbas
     * @return array
     */
    private function updateItemRequest()
    {
        return [
            'rules'   =>  [
                'sub_category_id' =>   ['required' , 'exists:categories,id'] ,
                'source_id'       =>   ['required' , 'exists:sources,id']    ,
                'capacity'        =>   ['required'] ,
                'plan_type'       =>   ['required'] ,
                'validaty'        =>   ['required'] ,
                'package_id'      =>   ['required'] ,
                'cost_price'      =>   ['required'] ,
                'retail_price'    =>   ['required'] ,
            ],
        ];
    }

    /**
     * Get the validation rules for storing a new item.
     *
     * @author Salah Derbas
     * @return array
     */
    private function storeItemRequest()
    {
        return [
            'rules'   =>  [
                'sub_category_id' =>   ['required' , 'exists:categories,id'] ,
                'source_id'       =>   ['required' , 'exists:sources,id']    ,
                'capacity'        =>   ['required'] ,
                'plan_type'       =>   ['required'] ,
                'validaty'        =>   ['required'] ,
                'package_id'      =>   ['required'] ,
                'cost_price'      =>   ['required'] ,
                'retail_price'    =>   ['required'] ,
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
            self::ROUTE_ITEM_STORE                => $this->storeItemRequest(),
            self::ROUTE_ITEM_SHOW                 => $this->showItemRequest(),
            self::ROUTE_ITEM_UPDATE               => $this->updateItemRequest(),
            self::ROUTE_ITEM_DELETE               => $this->deleteItemRequest(),
            self::ROUTE_ITEM_EDIT                 => $this->editItemRequest(),
            self::ROUTE_ITEM_SWITCH_STATUS        => $this->switchStatusItemRequest(),
            self::ROUTE_ITEM_SWITCH_SLIDER        => $this->switchSliderItemRequest(),

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
