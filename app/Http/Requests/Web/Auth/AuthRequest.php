<?php

namespace App\Http\Requests\Web\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\API\V1\b2c\Auth\UserIsDelete;
use App\Rules\Web\admin\AdminIsDisable;

class AuthRequest extends FormRequest
{
    private const ROUTE_LOGIN              = 'auth.login';
    private const ROUTE_CHECK_OTP          = 'auth.checkOtp';
    private const ROUTE_ADMIN_LOGIN        = 'admin.auth.loginAdmin';

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    private function loginAdminRequest()
    {
        return [
            'rules'   =>  [
                'email'            => ['required' , 'exists:admins,email' , 'email'] ,
                'password'         => ['required'  , 'min:6' , 'max:12'],
                'status'           => [new AdminIsDisable($this->email)],
        ],
    ];

    }
    /**
     * Get the validation rules that apply to the login request.
     *
     * @return array
     * @author Salah Derbas
     */
    private function loginRequest()
    {
        return [
            'rules'   =>  [
                    'email'            => ['required' , 'exists:users' , 'email'] ,
                    'password'         => ['required'  , 'min:6' , 'max:12'],
                    'status'           => [new UserIsDelete($this->email)],
            ],
        ];
    }


    /**
     * Get the validation rules that apply to the OTP check request.
     *
     * @return array
     * @author Salah Derbas
     */
    private function checkOtpRequest()
    {
        return [
            'rules'   =>  [
                'email'          => ['required' , 'exists:users' , 'email'] ,
                'pincode'        => ['required' ]
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
                self::ROUTE_LOGIN                => $this->loginRequest(),
                self::ROUTE_CHECK_OTP            => $this->checkOtpRequest(),
                self::ROUTE_ADMIN_LOGIN          => $this->loginAdminRequest(),

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
