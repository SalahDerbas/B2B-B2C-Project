<?php

namespace App\Http\Requests\Web\admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    private const ROUTE_CATEGORY_STORE              = 'admin.categories.store';
    private const ROUTE_CATEGORY_UPDATE             = 'admin.categories.update';
    private const ROUTE_CATEGORY_DELETE             = 'admin.categories.delete';
    private const ROUTE_CATEGORY_EDIT               = 'admin.categories.edit';
    private const ROUTE_CATEGORY_SWITCH_STATUS      = 'admin.categories.switchStatus';
    private const ROUTE_CATEGORY_GET_ITEMS          = 'admin.categories.getItems';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules for get items by category_id.
     *
     * @author Salah Derbas
     * @return array
     */
    private function getItemsCategoryRequest()
    {
        return [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:categories,id'] ,
            ],
        ];
    }
    /**
     * Get the validation rules for switching the Category status.
     *
     * @author Salah Derbas
     * @return array
     */
    private function switchStatusCategoryRequest()
    {
        return [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:categories,id'] ,
            ],
        ];
    }

    /**
     * Get the validation rules for editing an Category.
     *
     * @author Salah Derbas
     * @return array
     */
    private function editCategoryRequest()
    {
        return [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:categories,id'] ,
            ],
        ];
    }

    /**
     * Get the validation rules for deleting an Category.
     *
     * @author Salah Derbas
     * @return array
     */
    private function deleteCategoryRequest()
    {
        return [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:categories,id'] ,
            ],
        ];
    }

    /**
     * Get the validation rules for updating an Category.
     *
     * @author Salah Derbas
     * @return array
     */
    private function updateCategoryRequest()
    {
        return [
            'rules'   =>  [
                'name'              =>  ['required'] ,
                'description'       =>  ['nullable'] ,
                'color'             =>  ['nullable'] ,
                'sub_category_id'   =>  ['nullable'] ,
            ],
        ];
    }

    /**
     * Get the validation rules for storing a new Category.
     *
     * @author Salah Derbas
     * @return array
     */
    private function storeCategoryRequest()
    {
        return [
            'rules'   =>  [
                'name'              =>  ['required'] ,
                'description'       =>  ['nullable'] ,
                'color'             =>  ['nullable'] ,
                'sub_category_id'   =>  ['nullable'] ,
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
            self::ROUTE_CATEGORY_STORE                => $this->storeCategoryRequest(),
            self::ROUTE_CATEGORY_UPDATE               => $this->updateCategoryRequest(),
            self::ROUTE_CATEGORY_DELETE               => $this->deleteCategoryRequest(),
            self::ROUTE_CATEGORY_EDIT                 => $this->editCategoryRequest(),
            self::ROUTE_CATEGORY_SWITCH_STATUS        => $this->switchStatusCategoryRequest(),
            self::ROUTE_CATEGORY_GET_ITEMS            => $this->getItemsCategoryRequest(),

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
