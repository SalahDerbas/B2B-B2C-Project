<?php

namespace App\Http\Requests\Web\admin;

use Illuminate\Foundation\Http\FormRequest;

class SourceRequest extends FormRequest
{
    private const ROUTE_SOURCE_STORE              = 'admin.sources.store';
    private const ROUTE_SOURCE_UPDATE             = 'admin.sources.update';
    private const ROUTE_SOURCE_DELETE             = 'admin.sources.delete';
    private const ROUTE_SOURCE_EDIT               = 'admin.sources.edit';
    private const ROUTE_SOURCE_SWITCH_STATUS      = 'admin.sources.switchStatus';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules for switching the source status.
     *
     * @author Salah Derbas
     * @return array
     */
    private function switchStatusSourceRequest()
    {
        return [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:sources,id'] ,
            ],
        ];
    }

    /**
     * Get the validation rules for editing an source.
     *
     * @author Salah Derbas
     * @return array
     */
    private function editSourceRequest()
    {
        return [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:sources,id'] ,
            ],
        ];
    }

    /**
     * Get the validation rules for deleting an source.
     *
     * @author Salah Derbas
     * @return array
     */
    private function deleteSourceRequest()
    {
        return [
            'rules'   =>  [
                'id'          =>  ['required' , 'exists:sources,id'] ,
            ],
        ];
    }

    /**
     * Get the validation rules for updating an source.
     *
     * @author Salah Derbas
     * @return array
     */
    private function updateSourceRequest()
    {
        return [
            'rules'   =>  [
                'name'          =>  ['required'] ,
            ],
        ];
    }

    /**
     * Get the validation rules for storing a new source.
     *
     * @author Salah Derbas
     * @return array
     */
    private function storeSourceRequest()
    {
        return [
            'rules'   =>  [
                'name'          =>  ['required'] ,
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
            self::ROUTE_SOURCE_STORE                => $this->storeSourceRequest(),
            self::ROUTE_SOURCE_UPDATE               => $this->updateSourceRequest(),
            self::ROUTE_SOURCE_DELETE               => $this->deleteSourceRequest(),
            self::ROUTE_SOURCE_EDIT                 => $this->editSourceRequest(),
            self::ROUTE_SOURCE_SWITCH_STATUS        => $this->switchStatusSourceRequest(),

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
