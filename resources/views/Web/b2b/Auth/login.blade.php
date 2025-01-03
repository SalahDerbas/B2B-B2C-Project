@extends('Web.b2b.Auth.layouts.app')

@section('title', 'Login - B2B Dashboard')

@section('content')
<div class="row">
    <div class="col align-items-center flex-col">
    </div>

    <div class="col align-items-center flex-col sign-in">
        <div class="form-wrapper align-items-center">
            <form method="POST" action="{{ route('b2b.auth.login') }}">
                @csrf
                <div class="form sign-in">
                    <div class="input-group">
                        <i class='bx bxs-user'></i>
                        <input type="email" placeholder="Enter Email"
                               class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email"  value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group">
                        <i class='bx bxs-lock-alt'></i>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror" name="password"
                               required autocomplete="current-password" placeholder="Enter Password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button> Submit </button>
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
            <h2>B2B Dashboard</h2>
        </div>
        <div class="img sign-in">
        </div>
    </div>
</div>
@endsection
