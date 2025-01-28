@extends('layouts.master')

@section('title', 'Admin Dashboard')
@section('title_page', 'B2Bs')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="card-header">
                        <h3>Update B2B</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.b2bs.update') }}" method="POST">
                            <input type="hidden" id="id" name="id" value="{{ $data['id'] }}" />
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="username">User Name</label><br />
                                    <input type="text" id="username" name="username" value="{{ $data['usrename'] }}" class="@error('username') is-invalid @enderror" required>
                                    @error('username')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="name">Name</label><br />
                                    <input type="text" id="name" name="name" value="{{ $data['name'] }}" class="@error('name') is-invalid @enderror" required>
                                    @error('name')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="email">Email</label><br />
                                    <input type="email" id="email" name="email" value="{{ $data['email'] }}" class="@error('email') is-invalid @enderror" required>
                                    @error('email')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="password">Password</label><br />
                                    <input type="password" id="password" name="password" value="{{ $data['password'] }}" class="@error('password') is-invalid @enderror" required>
                                    @error('password')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="b2b_balance">Balance</label><br />
                                    <input type="number" id="b2b_balance" name="b2b_balance" value="{{ $data['b2b_balance'] }}" step="0.0001" min="0" class="@error('b2b_balance') is-invalid @enderror" required>
                                    @error('b2b_balance')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <br />
                            <div class="row" style="display: flex; justify-content: center; align-items: center;">
                                <button type="submit" style="width:auto;">Send Request</button>
                            </div>
                        </form>


                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <a href="{{ route('admin.b2bs.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

@endsection
