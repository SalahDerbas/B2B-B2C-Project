<?php

namespace App\Http\Controllers\Web\b2b\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Web\b2b\Auth\AuthRequest;
use App\Jobs\API\V1\b2b\Auth\SendOTPEmailJob;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Carbon\Carbon;

class AuthContoller extends Controller
{
    /**
     * Show the login page.
     *
     * @return \Illuminate\View\View
     */
    public function loginPage()
    {
        return view('Web.b2b.Auth.login');
    }

    /**
     * Attempt to log in the user.
     *
     * @param AuthRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(AuthRequest $request)
    {
        if(!Auth::attempt(['email'  => $request->email  ,'password' => $request->password]))
            return back()->withErrors(['email' => 'Invalid credentials']);

        return $this->sendOTPEmail($request->email , rand(10000 , 99999));
    }

    /**
     * Show the check OTP page.
     *
     * @return \Illuminate\View\View
     */
    public function checkOtpPage()
    {
        return view('Web.b2b.Auth.check-otp');
    }

    /**
     * Validate and check the OTP entered by the user.
     *
     * @param AuthRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function checkOtp(AuthRequest $request)
    {
        $user = User::where('email' , $request->email)->first();
        $validate = $this->validateOTP($user , implode('', $request->pincode) );
        if(!$validate['success'])
            return back()->withErrors($validate['message']);

        Auth::guard('web')->login($user);
        return redirect()->route('b2b.dashboard');
    }

    /**
     * Resend the OTP to the user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendOtp()
    {
        return $this->sendOTPEmail(Session::get('email') , rand(10000 , 99999));
    }

    /**
     * Validate the OTP entered by the user.
     *
     * @param User $user
     * @param string $pincode
     * @return array
     */
    private function validateOTP($user , $pincode)
    {
        if(Carbon::now()->isAfter($user['expire_time']))
            return ['success' => false , 'message' => ['error_otp_finish' => 'OTP is Finish Time']];

        if( $user['code_auth'] !=  $pincode)
            return ['success' => false , 'message' => ['error_two_factor' => 'OTP is Invalid!']];

        return ['success' => true , 'message' => []];
    }

    /**
     * Send OTP email to the user.
     *
     * @param string $email
     * @param int $otp
     * @return \Illuminate\Http\RedirectResponse
     */
    private function sendOTPEmail($email , $otp)
    {
        SendOTPEmailJob::dispatch($email, $otp);
        User::where(['email' => $email])->update(['code_auth' => $otp , 'expire_time' => Carbon::now()->addMinutes(3)]);
        Session::put('email', $email);

        return redirect()->route('b2b.auth.checkOtpPage');
    }

}
