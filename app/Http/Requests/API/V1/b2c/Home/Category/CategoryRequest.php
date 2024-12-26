<?php

namespace App\Http\Requests\API\V1\b2c\Home\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\Http\Requests\API\BaseRequest;

class CategoryRequest extends BaseRequest
{
    private const ROUTE_GET_CATEGORY_SUB_CATEGORY     = 'api.home.category.show';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     * @author Salah Derbas
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules for the contact us request.
     *
     * @return array
     * @author Salah Derbas
     */
    private function showRequest()
    {
        return [
            'rules'   =>  [
                'id'                  => ['required', 'exists:categories,id'],
            ],
            'messages'  => [
                'id.required'         => getStatusText(ID_REQUIRED_CODE),
                'id.exists'           => getStatusText(ID_EXISTS_CODE),
            ],
        ];
    }

    /**
     * Retrieve requested validation data based on the current route.
     *
     * @param string $key
     * @return mixed
     * @author Salah Derbas
     */
    private function requested($key)
    {
        $route = $this->route()->getName();
        $data = match ($route) {
                self::ROUTE_GET_CATEGORY_SUB_CATEGORY     => $this->showRequest(),
            default => []
        };
        return $data[$key];

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @author Salah Derbas
     */
    public function rules()
    {
        return $this->requested('rules');
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     * @author Salah Derbas
     */
    public function messages()
    {
        return $this->requested('messages');
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @author Salah Derbas
     */
    protected function failedValidation(Validator $validator)
    {
        $route             =  $this->route()->getName();
        $messages          = $this->messages();

        $errorMap = match ($route) {
                self::ROUTE_GET_CATEGORY_SUB_CATEGORY => [
                        $messages['id.required']        => ID_REQUIRED_CODE ,
                        $messages['id.exists']          => ID_EXISTS_CODE,
        ],
            default => []
        };

        $this->handleFailedValidation($validator, $errorMap);
    }

}
