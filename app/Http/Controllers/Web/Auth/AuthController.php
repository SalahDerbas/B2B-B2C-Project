<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Web\Auth\AuthRequest;
use App\Jobs\API\V1\b2b\Auth\SendOTPEmailJob;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Function to return the login page view.
     *
     * @author Salah Derbas
     * @return \Illuminate\View\View The login page view.
     */
    public function loginPage()
    {
        return view('Web.Auth.login');
    }

    /**
     * Handles the login request and sends an OTP email upon successful authentication.
     *
     * @author Salah Derbas
     * @param \App\Http\Requests\AuthRequest $request The incoming authentication request.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response Redirects back with errors if authentication fails, or sends an OTP email on success.
     */
    public function login(AuthRequest $request)
    {
        if(!Auth::attempt(['email'  => $request->email  ,'password' => $request->password]))
            return back()->withErrors(['email' => 'Invalid credentials']);

        return $this->sendOTPEmail($request->email , rand(10000 , 99999));
    }

    /**
     * Displays the OTP verification page.
     *
     * @author Salah Derbas
     * @return \Illuminate\View\View The OTP verification page view.
     */
    public function checkOtpPage()
    {
        return view('Web.Auth.check-otp');
    }

    /**
     * Handles the OTP verification process.
     *
     * @author Salah Derbas
     * @param AuthRequest $request The incoming OTP verification request.
     * @return \Illuminate\Http\RedirectResponse Redirects back with errors if OTP verification fails, or logs in the user and redirects to the home page on success.
     */
    public function checkOtp(AuthRequest $request)
    {
        $user = User::where('email' , $request->email)->first();
        $validate = $this->validateOTP($user , $request->pincode );
        if(!$validate['success'])
            return back()->withErrors($validate['message']);

        Auth::guard('web')->login($user);
        return redirect()->route('b2b.home');
    }

    /**
     * Resends the OTP email to the user.
     *
     * @author Salah Derbas
     * @return \Illuminate\Http\Response Sends an OTP email to the user's email stored in the session.
     */
    public function resendOtp()
    {
        return $this->sendOTPEmail(Session::get('email') , rand(10000 , 99999));
    }

    /**
     * Validates the OTP provided by the user.
     *
     * @author Salah Derbas
     * @param \App\Models\User $user The user whose OTP needs to be validated.
     * @param string $pincode The OTP code entered by the user.
     * @return array An array containing 'success' status and a 'message' array with error or success information.
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
     * Sends an OTP email to the provided email address and stores the OTP in the database.
     *
     * @author Salah Derbas
     * @param string $email The email address where the OTP will be sent.
     * @param int $otp The OTP to be sent to the user.
     * @return \Illuminate\Http\RedirectResponse Redirects to the OTP check page after sending the OTP email.
     */
    private function sendOTPEmail($email , $otp)
    {
        SendOTPEmailJob::dispatch($email, $otp);
        User::where(['email' => $email])->update(['code_auth' => $otp , 'expire_time' => Carbon::now()->addMinutes(3)]);
        Session::put('email', $email);

        return redirect()->route('auth.checkOtpPage');
    }

    /**
     * Logs the user out, invalidates the session, and regenerates the CSRF token.
     *
     * @author Salah Derbas
     * @return \Illuminate\Http\RedirectResponse Redirects the user to the login page after logout.
     */
    public function logout()
    {
        Auth::guard('web')->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('auth.loginPage');
    }
}
