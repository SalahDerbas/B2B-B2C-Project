@extends('layouts.master')

@section('title', 'B2B Dashboard')
@section('title_page', 'User')

@section('content')
<div class="row" style="font-size: 20px;">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <strong>Username:</strong> {{ $user->usrename }}
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <strong>Name:</strong> {{ $user->name }}
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <strong>Email:</strong> {{ $user->email }}
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <strong>Email Verified At:</strong>
                                    {{ formatDate($user->email_verified_at) }}
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <strong>Last Login:</strong>
                                    {{ formatDate($user->last_login) }}
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <strong>B2B Balance:</strong> <span class="badge bg-info" style="font-size: 25px;height: 33px;width: 50%;padding-top: 10px;">{{ number_format($user->b2b_balance, 2) }}$</span>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <strong>Account Created At:</strong> {{ formatDate($user->created_at) }}
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <strong>Last Updated At:</strong> {{ formatDate($user->updated_at) }}
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
