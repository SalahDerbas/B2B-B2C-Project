<?php

namespace App\Http\Requests\Web\admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Admin;

class AdminRequest extends FormRequest
{
    private const ROUTE_ADMIN_STORE              = 'admin.admins.store';
    private const ROUTE_ADMIN_UPDATE             = 'admin.admins.update';
    private const ROUTE_ADMIN_DELETE             = 'admin.admins.delete';
    private const ROUTE_ADMIN_EDIT               = 'admin.admins.edit';
    private const ROUTE_ADMIN_SWITCH_STATUS      = 'admin.admins.switchStatus';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules for switching the admin status.
     *
     * @author Salah Derbas
     * @return array
     */
    private function switchStatusAdminRequest()
    {
        return [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:admins,id'] ,
            ],
        ];
    }

    /**
     * Get the validation rules for editing an admin.
     *
     * @author Salah Derbas
     * @return array
     */
    private function editAdminRequest()
    {
        return [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:admins,id'] ,
            ],
        ];
    }

    /**
     * Get the validation rules for deleting an admin.
     *
     * @author Salah Derbas
     * @return array
     */
    private function deleteAdminRequest()
    {
        return [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:admins,id'] ,
            ],
        ];
    }

    /**
     * Get the validation rules for updating an admin.
     *
     * @author Salah Derbas
     * @return array
     */
    private function updateAdminRequest()
    {
        return [
            'rules'   =>  [
                'username'          =>  ['required'] ,
                'email'             =>  ['required'  ,  Rule::unique(Admin::getTableName(), "email")->ignore($this->id) , 'email'],
                'password'          =>  ['required'  , 'min:6' , 'max:12'],
            ],
        ];
    }

    /**
     * Get the validation rules for storing a new admin.
     *
     * @author Salah Derbas
     * @return array
     */
    private function storeAdminRequest()
    {
        return [
            'rules'   =>  [
                'username'          =>  ['required'] ,
                'email'             =>  ['required'  ,  Rule::unique(Admin::getTableName(), "email") , 'email'],
                'password'          =>  ['required'  , 'min:6' , 'max:12'],
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
            self::ROUTE_ADMIN_STORE                => $this->storeAdminRequest(),
            self::ROUTE_ADMIN_UPDATE               => $this->updateAdminRequest(),
            self::ROUTE_ADMIN_DELETE               => $this->deleteAdminRequest(),
            self::ROUTE_ADMIN_EDIT                 => $this->editAdminRequest(),
            self::ROUTE_ADMIN_SWITCH_STATUS        => $this->switchStatusAdminRequest(),

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
