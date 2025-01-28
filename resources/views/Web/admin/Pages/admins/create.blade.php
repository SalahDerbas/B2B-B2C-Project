@extends('layouts.master')

@section('title', 'Admin Dashboard')
@section('title_page', 'Admins')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="card-header">
                        <h3>Create Admin</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.admins.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="username">User Name</label><br />
                                    <input type="text" id="username" name="username" class="@error('username') is-invalid @enderror" required>
                                    @error('username')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="email">Email</label><br />
                                    <input type="email" id="email" name="email" class="@error('email') is-invalid @enderror" required>
                                    @error('email')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="password">Password</label><br />
                                    <input type="password" id="password" name="password" class="@error('password') is-invalid @enderror" required>
                                    @error('password')
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
        <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

@endsection
