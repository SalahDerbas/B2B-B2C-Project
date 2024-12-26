<?php

namespace App\Http\Requests\API\V1\b2c\Auth;

use App\Http\Requests\API\BaseRequest;
use Illuminate\Validation\Rule;

use Illuminate\Contracts\Validation\Validator;

use App\Rules\API\V1\b2c\Auth\UserIsDelete;
use App\Rules\API\V1\b2c\Auth\UserGoogleIdIsFound;
use App\Rules\API\V1\b2c\Auth\UserFacebookIdIsFound;
use App\Rules\API\V1\b2c\Auth\UserAppleIdIsFound;

use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AuthRequest extends BaseRequest
{

    private const ROUTE_LOGIN              = 'api.user.login';
    private const ROUTE_RIGISTER           = 'api.user.register';
    private const ROUTE_UPDATE_PROFILE     = 'api.user.update_profile';
    private const ROUTE_CHECK_OTP          = 'api.user.check_otp';
    private const ROUTE_RESEND_OTP         = 'api.user.resend_otp';
    private const ROUTE_LOGIN_BY_GOOGLE    = 'api.user.login_by_google';
    private const ROUTE_LOGIN_BY_FACEBOOK  = 'api.user.login_by_facebook';
    private const ROUTE_LOGIN_BY_APPLE     = 'api.user.login_by_apple';
    private const ROUTE_FORGET_PASSWORD    = 'api.user.forget_password';
    private const ROUTE_RESET_PASSWORD     = 'api.user.reset_password';


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
                    'status'                 => [new UserIsDelete($this->email)],
            ],
            'messages'  => [
                    'email'                 => getStatusText(EMAIL_EXISTS_CODE),
                    'password.required'     => getStatusText(PASSWORD_REQUIRED_CODE),
                    'status'                => getStatusText(USER_DELETED_CODE)
            ],
        ];
    }

    /**
     * Get the validation rules that apply to the store request.
     *
     * @return array
     * @author Salah Derbas
     */
    private function registerRequest()
    {
        return [
            'rules'   =>  [
                    'usrename'              => ['required' , 'unique:users' , 'regex:/^[\p{Arabic}a-zA-Z0-9\- .ـ]+$/u'],
                    'email'                 => ['required', 'string', 'email', 'max:255',  Rule::unique(User::getTableName(), "email"), 'regex:/^(?=[^@]*[A-Za-z])([a-zA-Z0-9])(([a-zA-Z0-9])*([\._-])?([a-zA-Z0-9]))*@(([a-zA-Z0-9\-])+(\.))+([a-zA-Z]{2,4})+$/i'],
                    'password'              => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/'],
                    'name'                  => ['required' ],
                    'phone'                 => ['required' ],
                    'photo'                 => ['file'  ],
            ],
            'messages'  => [
                    'usrename.required'           => getStatusText(NAME_REQUIRED_CODE),
                    'usrename.unique'             => getStatusText(NAME_UNIQUE_CODE),
                    'usrename.regex'              => getStatusText(NAME_REGEX_CODE),
                    'email.required'              => getStatusText(EMAIL_REQUIRED_CODE),
                    'email.string'                => getStatusText(EMAIL_STRING_CODE),
                    'email.email'                 => getStatusText(EMAIL_EMAIL_CODE),
                    'email.max'                   => getStatusText(EMAIL_MAX_CODE),
                    'email.unique'                => getStatusText(EMAIL_UNIQUE_CODE) ,
                    'email.regex'                 => getStatusText(EMAIL_REGEX_CODE) ,
                    'password'                    => getStatusText(PASSWORD_VALIDATION_CODE),
                    'name.required'               => getStatusText(NAME_CODE),
                    'phone.required'              => getStatusText(PHONE_CODE),
                    'photo.file'                  => getStatusText(PHOTO_FILE_CODE),
            ],
        ];
    }

    /**
     * Get the validation rules that apply to the update request.
     *
     * @return array
     * @author Salah Derbas
     */
    private function updateProfileRequest()
    {
        return [
            'rules'   =>  [
                    'usrename'              => ['required' , 'unique:users,usrename,'. auth()->id() , 'regex:/^[\p{Arabic}a-zA-Z0-9\- .ـ]+$/u'],
                    'email'                 => ['required', 'string', 'email', 'max:255',  'unique:users,email,'. auth()->id(), 'regex:/^(?=[^@]*[A-Za-z])([a-zA-Z0-9])(([a-zA-Z0-9])*([\._-])?([a-zA-Z0-9]))*@(([a-zA-Z0-9\-])+(\.))+([a-zA-Z]{2,4})+$/i'],
                    'name'                  => ['required' ],
                    'phone'                 => ['required' ],
                    'photo'                 => ['file'  ],
            ],
            'messages'  => [
                    'usrename.required'           => getStatusText(NAME_REQUIRED_CODE),
                    'usrename.unique'             => getStatusText(NAME_UNIQUE_CODE),
                    'usrename.regex'              => getStatusText(NAME_REGEX_CODE),
                    'email.required'              => getStatusText(EMAIL_REQUIRED_CODE),
                    'email.string'                => getStatusText(EMAIL_STRING_CODE),
                    'email.email'                 => getStatusText(EMAIL_EMAIL_CODE),
                    'email.max'                   => getStatusText(EMAIL_MAX_CODE),
                    'email.unique'                => getStatusText(EMAIL_UNIQUE_CODE) ,
                    'email.regex'                 => getStatusText(EMAIL_REGEX_CODE) ,
                    'name.required'               => getStatusText(NAME_CODE),
                    'phone.required'              => getStatusText(PHONE_CODE),
                    'photo.file'                  => getStatusText(PHOTO_FILE_CODE),
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
     * Get the validation rules for logging in via Google.
     *
     * @return array
     * @author Salah Derbas
     */
    private function loginByGoogleRequest()
    {
        return [
            'rules'   =>  [
                    'email'                    => ['required', 'email'],
                    'google_id'                => [new UserGoogleIdIsFound($this)],
                    'status'                   => [new UserIsDelete($this->email)],
            ],
            'messages'  => [
                    'email.required'           => getStatusText(EMAIL_REQUIRED_CODE),
                    'email.email'              => getStatusText(EMAIL_EMAIL_CODE),
                    'google_id'                => getStatusText(GOOGLE_FAILED_CODE),
                    'status'                   => getStatusText(USER_DELETED_CODE),
            ],
        ];
    }

    /**
     * Get the validation rules for logging in via Facebook.
     *
     * @return array
     * @author Salah Derbas
     */
    private function loginByFacebookRequest()
    {
        return [
            'rules'   =>  [
                'facebook_id'              => [new UserFacebookIdIsFound($this)],
            ],
            'messages'  => [
                'facebook_id'              => getStatusText(FACEBOOK_FAILED_CODE),
            ],
        ];
    }

    /**
     * Get the validation rules for logging in via Apple.
     *
     * @return array
     * @author Salah Derbas
     */
    private function loginByAppleRequest()
    {
        return [
            'rules'   =>  [
                'apple_id'              => [new UserAppleIdIsFound($this)],
            ],
            'messages'  => [
                'apple_id'              => getStatusText(APPLE_ID_FAILED_CODE),
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
                self::ROUTE_LOGIN                => $this->loginRequest(),
                self::ROUTE_RIGISTER             => $this->registerRequest(),
                self::ROUTE_UPDATE_PROFILE       => $this->updateProfileRequest(),
                self::ROUTE_CHECK_OTP            => $this->checkOtpRequest(),
                self::ROUTE_RESEND_OTP           => $this->resendOtpRequest(),
                self::ROUTE_LOGIN_BY_GOOGLE      => $this->loginByGoogleRequest(),
                self::ROUTE_LOGIN_BY_FACEBOOK    => $this->loginByFacebookRequest(),
                self::ROUTE_LOGIN_BY_APPLE       => $this->loginByAppleRequest(),
                self::ROUTE_FORGET_PASSWORD      => $this->forgetPasswordRequest(),
                self::ROUTE_RESET_PASSWORD       => $this->resetPasswordRequest(),

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
            self::ROUTE_LOGIN => [
                    $messages['email']                => EMAIL_EXISTS_CODE,
                    $messages['password.required']    => PASSWORD_REQUIRED_CODE,
                    $messages['status']               => USER_DELETED_CODE,
            ],
            self::ROUTE_RIGISTER => [
                    $messages['usrename.required']           => NAME_REQUIRED_CODE,
                    $messages['usrename.unique']             => NAME_UNIQUE_CODE,
                    $messages['usrename.regex']              => NAME_REGEX_CODE,
                    $messages['email.required']              => EMAIL_REQUIRED_CODE,
                    $messages['email.string']                => EMAIL_STRING_CODE,
                    $messages['email.email']                 => EMAIL_EMAIL_CODE,
                    $messages['email.max']                   => EMAIL_MAX_CODE,
                    $messages['email.unique']                => EMAIL_UNIQUE_CODE,
                    $messages['email.regex']                 => EMAIL_REGEX_CODE,
                    $messages['password']                    => PASSWORD_VALIDATION_CODE,
                    $messages['name.required']               => NAME_CODE,
                    $messages['phone.required']              => PHONE_CODE,
                    $messages['photo.file']                  => PHOTO_FILE_CODE,


            ],
            self::ROUTE_UPDATE_PROFILE => [
                $messages['usrename.required']           => NAME_REQUIRED_CODE,
                $messages['usrename.unique']             => NAME_UNIQUE_CODE,
                $messages['usrename.regex']              => NAME_REGEX_CODE,
                $messages['email.required']              => EMAIL_REQUIRED_CODE,
                $messages['email.string']                => EMAIL_STRING_CODE,
                $messages['email.email']                 => EMAIL_EMAIL_CODE,
                $messages['email.max']                   => EMAIL_MAX_CODE,
                $messages['email.unique']                => EMAIL_UNIQUE_CODE,
                $messages['email.regex']                 => EMAIL_REGEX_CODE,
                $messages['name.required']               => NAME_CODE,
                $messages['phone.required']              => PHONE_CODE,
                $messages['photo.file']                  => PHOTO_FILE_CODE,

            ],
            self::ROUTE_CHECK_OTP => [
                    $messages['otp.required']         => OTP_REQUIRED_CODE,
                    $messages['email.required']       => EMAIL_REQUIRED_CODE,
                    $messages['email.email']          => EMAIL_EMAIL_CODE,
                    $messages['email.exists']         => EMAIL_EXISTS_CODE,
            ],
            self::ROUTE_RESEND_OTP => [
                    $messages['email']                => EMAIL_EXISTS_CODE,
                    $messages['status']               => USER_DELETED_CODE,
            ],
            self::ROUTE_LOGIN_BY_GOOGLE => [
                    $messages['email.required']       => EMAIL_REQUIRED_CODE,
                    $messages['email.email']          => EMAIL_EMAIL_CODE,
                    $messages['google_id']            => GOOGLE_FAILED_CODE,
                    $messages['status']               => USER_DELETED_CODE,
            ],
            self::ROUTE_LOGIN_BY_FACEBOOK => [
                        $messages['facebook_id']      => FACEBOOK_FAILED_CODE,
            ],
            self::ROUTE_LOGIN_BY_APPLE   => [
                        $messages['apple_id']         => APPLE_ID_FAILED_CODE,
            ],
            self::ROUTE_FORGET_PASSWORD => [
                    $messages['email']                => EMAIL_EXISTS_CODE,
                    $messages['status']               => USER_DELETED_CODE,
            ],
            self::ROUTE_RESET_PASSWORD => [
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
