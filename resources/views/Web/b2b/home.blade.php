@extends('layouts.master')

@section('title', 'B2B Dashboard')

@section('content')
<div class="row">
    <div class="col-xl-3 col-lg-6 col-md-6 mb-30">
        <div class="card card-statistics h-80">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <span class="text-danger">
                            <i class="fa fa-bar-chart-o highlight-icon" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="float-right text-right">
                        <p class="card-text text-dark">E-SIM</p>
                        <a href="{{ route('b2b.manage_esims.index') }}">Go To E-SIM</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 mb-30">
        <div class="card card-statistics h-80">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <span class="text-warning">
                            <i class="fa fa-shopping-cart highlight-icon" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="float-right text-right">
                        <p class="card-text text-dark">Orders</p>
                        <a href="{{ route('b2b.api_orders.index') }}">Go To Order</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 mb-30">
        <div class="card card-statistics h-80">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <span class="text-success">
                            <i class="fa fa-dollar highlight-icon" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="float-right text-right">
                        <p class="card-text text-dark">Billing</p>
                        <a href="{{ route('b2b.billing.index') }}">Go To Billing</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 mb-30">
        <div class="card card-statistics h-80">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-left">
                        <span class="text-primary">
                            <i class="fa fa-twitter highlight-icon" aria-hidden="true"></i>
                        </span>
                    </div>
                    <div class="float-right text-right">
                        <p class="card-text text-dark">FAQ</p>
                        <a href="{{ route('b2b.faq.index') }}">Go To FAQ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

