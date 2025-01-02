<?php

namespace App\Http\Controllers\API\V1\b2b\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\API\V1\b2b\Auth\AuthRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Resources\API\V1\b2b\Auth\UserResource;
use Carbon\Carbon;
use App\Jobs\API\V1\b2b\Auth\SendOTPEmailJob;

class AuthController extends Controller
{
    /**
     * Login to the application.
     *
     * This function handles the login process for the user.
     *
     * @param string $email The email address of the user.
     * @param string $password The password provided by the user.
     * @return \Illuminate\Http\JsonResponse Returns a JSON response containing the authentication token on success.
     * @result string "login to application"
     * @throws \Exception
     * @author Salah Derbas
    */
    public function login(AuthRequest $request)
    {
        try{
            if (!Auth::attempt($request->all()))
                return responseError(getStatusText(INCCORECT_DATA_ERROR_CODE), Response::HTTP_UNPROCESSABLE_ENTITY ,INCCORECT_DATA_ERROR_CODE);

            User::where(['email'  => $request->email])->update(['last_login' => Carbon::now()  ]);
            return responseSuccess( new UserResource(Auth::user()) , getStatusText(LOGIN_SUCCESS_CODE)  , LOGIN_SUCCESS_CODE );
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Handle the "forgot password" process by sending an OTP email.
     *
     * This function generates a random 5-digit OTP and sends it to the
     * specified email address. It is used to initiate the password reset process.
     *
     * @param AuthRequest $request The request containing the user's email address.
     * @return \Illuminate\Http\JsonResponse The response after sending the OTP.
     * @author Salah Derbas
    */
    public function forgetPassword(AuthRequest $request)
    {
        try{
            return $this->sendOTPEmail($request->email , rand(10000 , 99999));
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }


    /**
     * Validate the OTP (One-Time Password) for a user based on the provided email and OTP code.
     * If the OTP is valid and has not expired, the user is authenticated and logged in.
     *
     * @param AuthRequest $request The incoming request containing the user's email and OTP.
     * @return \Illuminate\Http\JsonResponse The response indicating the success or failure of the OTP validation.
     * @author Salah Derbas
    */
    public function checkOtp(AuthRequest $request)
    {
        try{
            $user     = User::where(['email'=> $request->email , 'code_auth' => $request->otp ])->first();
            if(is_null($user))
                return responseError(getStatusText(OTP_INVALID_CODE), Response::HTTP_UNPROCESSABLE_ENTITY ,OTP_INVALID_CODE);

            if (Carbon::now()->isAfter($user->expire_time))
                return responseError(getStatusText(EXPIRE_TIME_INVALID_CODE), Response::HTTP_UNPROCESSABLE_ENTITY ,EXPIRE_TIME_INVALID_CODE);

            return $this->successAuth($user);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }

    }

    /**
     * Resend a One-Time Password (OTP) to the user's email address.
     * A random OTP is generated and sent via email to the provided email address.
     *
     * @param AuthRequest $request The incoming request containing the user's email.
     * @return mixed The result of the OTP email sending process.
     * @author Salah Derbas
    */
    public function resendOtp(AuthRequest $request)
    {
        try{
            return $this->sendOTPEmail($request->email , rand(10000 , 99999));
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Reset the user's password.
     *
     * This function locates the user by email and updates their password with a
     * newly provided password, securely hashing it before storage. It is typically
     * used after successful OTP verification during the password reset process.
     *
     * @param AuthRequest $request The request containing the user's email and new password.
     * @return \Illuminate\Http\JsonResponse A success response indicating password reset completion.
     * @author Salah Derbas
    */
    public function resetPassword(AuthRequest $request)
    {
        try{
            User::where(['email' => $request->email])->update(['password' => bcrypt($request->password)]);
            return responseSuccess('', getStatusText(RESET_NEW_PASSWOED_CODE), RESET_NEW_PASSWOED_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Retrieve the authenticated user's profile.
     *
     * This function retrieves the currently authenticated user's data and
     * returns it in a structured response. If an error occurs during retrieval,
     *
     * @return \Illuminate\Http\JsonResponse The success response with user profile data, or an error response if an exception occurs.
     * @author Salah Derbas
    */
    public function getProfile()
    {
        try{
            return responseSuccess(new UserResource( Auth::user() ) , getStatusText(GET_PROFILE_CODE), GET_PROFILE_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Refresh the user's authentication token.
     *
     * This function revokes the current token of the authenticated user
     * and issues a new token, wrapping the updated user data in a `UserResource`
     * for the response. Returns a success response if the token is successfully
     * refreshed or an error response if an exception occurs.
     *
     * @return \Illuminate\Http\JsonResponse
     * @author Salah Derbas
    */
    public function refreshToken()
    {
        try{
            Auth::user()->token()->revoke();
            return responseSuccess(new UserResource( Auth::user() ) , getStatusText(REFRESH_TOKEN_CODE), REFRESH_TOKEN_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }

    /**
     * Log out the authenticated user.
     *
     * This function revokes the current token of the authenticated user,
     * effectively logging them out. Returns a success response upon successful
     * logout or an error response if an exception occurs.
     *
     * @return \Illuminate\Http\JsonResponse
     * @author Salah Derbas
    */
    public function logout()
    {
        try{
            Auth::user()->token()->revoke();
            return responseSuccess('', getStatusText(USER_LOGOUT_CODE), USER_LOGOUT_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }


    public function getBalance()
    {
        try{
            return responseSuccess( ['b2b_balance' => Auth::user()->b2b_balance] , getStatusText(GET_B2B_BALANCE_CODE), GET_B2B_BALANCE_CODE);
        } catch (\Exception $e) {
            return responseError($e->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY ,DATA_ERROR_CODE);
        }
    }



    /**
     * Re-send email to the application.
     *
     * This function handles the Re-send email process for the user.
     *
     * @param string $email The email address of the user.
     * @return \Illuminate\Http\JsonResponse Returns a JSON response containing the authentication token on success.
     * @result string "send OTP to email for user for verify"
     * @throws \Exception
     * @author Salah Derbas
    */
    private function sendOTPEmail($email , $otp)
    {
        SendOTPEmailJob::dispatch($email, $otp);
        User::where('email' , $email)->update(['code_auth' => $otp , 'expire_time' => Carbon::now()->addMinutes(3)]);

        return responseSuccess('', getStatusText(SEND_OTP_SUCCESS_CODE) ,SEND_OTP_SUCCESS_CODE);
    }

    /**
     * Log in the user after successful OTP validation and retrieve the user's details with relations.
     *
     * @param User $user The authenticated user object.
     * @return \Illuminate\Http\JsonResponse The response containing the user's information and success status.
     * @author Salah Derbas
    */
    private function successAuth($user)
    {
        Auth::login($user);
        return responseSuccess( new UserResource($user) , getStatusText(LOGIN_SUCCESS_CODE)  , LOGIN_SUCCESS_CODE );
    }





}
