<?php

namespace App\Http\Requests\API\V1\b2b\Auth;

use App\Http\Requests\API\BaseRequest;
use App\Rules\API\V1\b2c\Auth\UserIsDelete;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Auth;


class AuthRequest extends BaseRequest
{

    private const ROUTE_B2B_LOGIN              = 'api.b2b.user.login';
    private const ROUTE_B2B_FORGET_PASSWORD    = 'api.b2b.user.forget_password';
    private const ROUTE_B2B_CHECK_OTP          = 'api.b2b.user.check_otp';
    private const ROUTE_B2B_RESEND_OTP         = 'api.b2b.user.resend_otp';
    private const ROUTE_B2B_RESET_PASSWORD     = 'api.b2b.user.reset_password';

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
     * Get the validation rules that apply to the login request.
     *
     * @return array
     * @author Salah Derbas
     */
    private function loginRequest()
    {
        return [
            'rules'   =>  [
                    'email'                  => ['exists:users,email'],
                    'password'               => ['required'],
                    'client_id'              => ['required','exists:users,client_id'],
                    'client_secret'          => ['required','exists:users,client_secret'],
                    'status'                 => [new UserIsDelete($this->email)],
            ],
            'messages'  => [
                    'email'                      => getStatusText(EMAIL_EXISTS_CODE),
                    'password.required'          => getStatusText(PASSWORD_REQUIRED_CODE),
                    'client_id.required'         => getStatusText(CLIENT_ID_REQUIRED_CODE),
                    'client_id.exists'           => getStatusText(CLIENT_ID_EXISTS_CODE),
                    'client_secret.required'     => getStatusText(CLIENT_SECRET_REQUIRED_CODE),
                    'client_secret.exists'       => getStatusText(CLIENT_SECRET_EXISTS_CODE),
                    'status'                     => getStatusText(USER_DELETED_CODE)
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
                    'otp'                   => ['required'],
                    'email'                 => ['required', 'email', 'exists:users,email'],
            ],
            'messages'  => [
                    'otp.required'          => getStatusText(OTP_REQUIRED_CODE),
                    'email.required'        => getStatusText(EMAIL_REQUIRED_CODE),
                    'email.email'           => getStatusText(EMAIL_EMAIL_CODE),
                    'email.exists'          => getStatusText(EMAIL_EXISTS_CODE),
            ],
        ];
    }

    /**
     * Get the validation rules for resending the OTP.
     *
     * @return array
     * @author Salah Derbas
     */
    private function resendOtpRequest(){
        return [
            'rules'   =>  [
                    'email'                => ['exists:users,email'],
                    'status'               => [new UserIsDelete($this->email)]
            ],
            'messages'  => [
                    'email'                => getStatusText(EMAIL_EXISTS_CODE),
                    'status'               => getStatusText(USER_DELETED_CODE)
            ],
        ];
    }

    /**
     * Get the validation rules for forgetting the password.
     *
     * @return array
     * @author Salah Derbas
     */
    private function forgetPasswordRequest()
    {
        return [
            'rules'   =>  [
                    'email'                    => ['exists:users,email'],
                    'status'                   => [new UserIsDelete($this->email)]
            ],
            'messages'  => [
                    'email'                    => getStatusText(EMAIL_EXISTS_CODE),
                    'status'                   => getStatusText(USER_DELETED_CODE),
            ],
        ];
    }


    /**
     * Get the validation rules for resetting the password.
     *
     * @return array
     * @author Salah Derbas
     */
    private function resetPasswordRequest()
    {
        return [
            'rules'   =>  [
                    'email'                           => ['required' ,'email' , 'exists:users,email' ],
                    'password'                        => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/'],
                    'confirm_password'                => ['required_with:password','same:password','min:6'],
            ],
            'messages'  => [
                    'email.required'                  => getStatusText(EMAIL_REQUIRED_CODE),
                    'email.email'                     => getStatusText(EMAIL_EMAIL_CODE),
                    'email.exists'                    => getStatusText(EMAIL_EXISTS_CODE),
                    'password'                        => getStatusText(PASSWORD_VALIDATION_CODE),
                    'confirm_password.required_with'  => getStatusText(CONFIRM_PASSWORD_REQUIRED_WITH_CODE)  ,
                    'confirm_password.same'           => getStatusText(CONFIRM_PASSWORD_SAME_CODE)  ,
                    'confirm_password.min'            => getStatusText(CONFIRM_PASSWORD_MIN_CODE)   ,
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
                self::ROUTE_B2B_LOGIN                => $this->loginRequest(),
                self::ROUTE_B2B_FORGET_PASSWORD      => $this->forgetPasswordRequest(),
                self::ROUTE_B2B_CHECK_OTP            => $this->checkOtpRequest(),
                self::ROUTE_B2B_RESEND_OTP           => $this->resendOtpRequest(),
                self::ROUTE_B2B_RESET_PASSWORD       => $this->resetPasswordRequest(),

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

    /**
     * Get the validation messages for the request.
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
        $route      = $this->route()->getName();
        $messages   = $this->messages();

        $errorMap = match ($route) {
            self::ROUTE_B2B_LOGIN => [
                    $messages['email']                          => EMAIL_EXISTS_CODE,
                    $messages['password.required']              => PASSWORD_REQUIRED_CODE,
                    $messages['status']                         => USER_DELETED_CODE,
                    $messages['client_id.required']             => CLIENT_ID_REQUIRED_CODE,
                    $messages['client_id.exists']               => CLIENT_ID_EXISTS_CODE,
                    $messages['client_secret.required']         => CLIENT_SECRET_REQUIRED_CODE,
                    $messages['client_secret.exists']           => CLIENT_SECRET_EXISTS_CODE,
            ],
            self::ROUTE_B2B_FORGET_PASSWORD => [
                    $messages['email']                          => EMAIL_EXISTS_CODE,
                    $messages['status']                         => USER_DELETED_CODE,
            ],
            self::ROUTE_B2B_CHECK_OTP => [
                    $messages['otp.required']                   => OTP_REQUIRED_CODE,
                    $messages['email.required']                 => EMAIL_REQUIRED_CODE,
                    $messages['email.email']                    => EMAIL_EMAIL_CODE,
                    $messages['email.exists']                   => EMAIL_EXISTS_CODE,
            ],
            self::ROUTE_B2B_RESEND_OTP => [
                    $messages['email']                          => EMAIL_EXISTS_CODE,
                    $messages['status']                         => USER_DELETED_CODE,
            ],
            self::ROUTE_B2B_RESET_PASSWORD => [
                    $messages['email.required']                 => EMAIL_REQUIRED_CODE,
                    $messages['email.email']                    => EMAIL_EMAIL_CODE,
                    $messages['email.exists']                   => EMAIL_EXISTS_CODE,
                    $messages['password']                       => PASSWORD_VALIDATION_CODE,
                    $messages['confirm_password.required_with'] => CONFIRM_PASSWORD_REQUIRED_WITH_CODE,
                    $messages['confirm_password.same']          => CONFIRM_PASSWORD_SAME_CODE,
                    $messages['confirm_password.min']           => CONFIRM_PASSWORD_MIN_CODE,
            ],
            default => []
        };

        $this->handleFailedValidation($validator, $errorMap);
    }

}
