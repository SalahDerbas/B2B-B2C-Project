@extends('Web.Auth.layouts.app')

@section('title', 'Login - B2B Dashboard')

@section('content')
<div class="row">
    <div class="col align-items-center flex-col">
    </div>

    <div class="col align-items-center flex-col sign-in">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-wrapper align-items-center">
            @if($isAdmin)
                <form method="POST" action="{{ route('admin.auth.loginAdmin') }}">
            @else
                <form method="POST" action="{{ route('auth.login') }}">
            @endif
                @csrf
                <div class="form sign-in">
                    <div class="input-group">
                        <i class='bx bxs-user'></i>
                        <input type="email" placeholder="Enter Email"
                               class="form-control @error('email') is-invalid @enderror"
                               id="email" name="email"  value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif

                    </div>
                    <div class="input-group">
                        <i class='bx bxs-lock-alt'></i>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror" name="password"
                               required autocomplete="current-password" placeholder="Enter Password">
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
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
