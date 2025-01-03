@extends('Web.b2b.Auth.layouts.app')

@section('title', 'Check-OTP - B2B Dashboard')

@section('content')
<div class="row">
    <div class="col align-items-center flex-col">
    </div>


    <div class="col align-items-center flex-col sign-in">
        @if($errors->has('error_two_factor'))
        <div class="alert alert-danger">
            {{ $errors->first('error_two_factor') }}
        </div>
        @endif
        @if($errors->has('error_otp_finish'))
        <div class="alert alert-danger">
            {{ $errors->first('error_otp_finish') }}
        </div>
        @endif
        <div class="form-wrapper align-items-center">

        <form method="POST" action="{{ route('b2b.auth.checkOtp') }}">
            @csrf

            <div class="form sign-in">
                    <input autocomplete="off" type="hidden" class="form-control" id="email" name="email"
                    placeholder="Email" aria-describedby="login-email"
                    tabindex="1" autofocus value="{{session('email')}}"/>
                <div class="input-group">
                    <i class='bx bxs-lock-alt'></i>
                    <div class="pin-container">
                        <input type="password" name="pincode[]" pattern="[\d]*"  maxlength="1" class="pin-input" id="pin1">
                        <input type="password" name="pincode[]" pattern="[\d]*"  maxlength="1" class="pin-input" id="pin2">
                        <input type="password" name="pincode[]" pattern="[\d]*"  maxlength="1" class="pin-input" id="pin3">
                        <input type="password" name="pincode[]" pattern="[\d]*"  maxlength="1" class="pin-input" id="pin4">
                        <input type="password" name="pincode[]" pattern="[\d]*"  maxlength="1" class="pin-input" id="pin5">
                    </div>

                </div>
                <button> Submit </button>
                <p>
                    <span>
                        <a href="{{ route('b2b.auth.resendOtp')}}" > <h4> Re-Send OTP </h4> </a>

                    </span>
                </p>
            </div>
        </form>


        </div>
        <div class="form-wrapper">

        </div>
    </div>
</div>
<div class="row content-row">
    <div class="col align-items-center flex-col">
        <div class="text sign-in">
            <h2>
                B2B Dashboard
            </h2>

        </div>
        <div class="img sign-in">

        </div>
    </div>
</div>
@endsection
