@extends('layouts.master')

@section('title', 'B2B Dashboard')
@section('title_page', 'API Orders')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-statistics h-100">
            <div class="card-body">

                <div class="card-header">
                    <h3>Order Details</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Email:</strong>
                                <span>{{ $data->email ?? 'N/A' }}</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Final Price:</strong>
                                <span>{{ $data->final_price ?? 'N/A' }}</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>ICCID:</strong>
                                <span>{{ $data->iccid ?? 'N/A' }}</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Order Data:</strong>
                                <span><a href="{{ route('order.callBack.success' , ['order_id' =>  encryptWithKey( $data['id'] , 'B2B-B2C') ])}}" target="_blank">Data</a></span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Created At:</strong>
                                <span>{{ formatDate($data->created_at)  ?? 'N/A'  }}</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Updated At:</strong>
                                <span>{{ formatDate($data->updated_at)  ?? 'N/A'  }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-6">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <div class="card-header">
                    <h3>Order Details</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Item:</strong>
                                <span>{{'('.$data->getItem->capacity.')-('.$data->getItem->plan_type.')-('.$data->getItem->validaty.')' ?? 'N/A'}}</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>User:</strong>
                                <span> {{ '('.$data->getUser->name.')-('.$data->getUser->email.')'  ?? 'N/A' }} </span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Category:</strong>
                                <span> {{ $data->getCategory->name  ?? 'N/A' }} </span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Photo:</strong>
                                <span><img src="{{$data->getCategory->photo}}" width="150" height="100" /></span>

                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="">
                                <strong>Coverages:</strong>
                                <span>
                                    @if (isset($data->getItem->coverages))
                                        <ul>

                                            @foreach (json_decode($data->getItem->coverages) as $coverage)
                                            <li class="list-group-item">
                                                <div class="d-flex justify-content-between">
                                                    <strong>Country Code:</strong>
                                                    <span>{{ $coverage->country_code ?? 'N/A' }}</span>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="d-flex justify-content-between">
                                                    <strong>Country:</strong>
                                                    <span>{{ $coverage->country ?? 'N/A' }}</span>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="d-flex justify-content-between">
                                                    <strong>Flag:</strong>
                                                    <span><img src="{{$coverage->flag}}" width="50" height="35" /></span>
                                                </div>
                                            </li>
                                            <li class="list-group-item">
                                                <div class="d-flex justify-content-between">
                                                    <strong>Operaters:</strong>
                                                    <ul>
                                                        @foreach ($coverage->networks as $network)
                                                            <li>{{ $network->name }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </li>
                                        @endforeach
                                        </ul>
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                        </li>

                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Status Order:</strong>
                                <span class="badge badge-info" style="font-size: 20px;"> {{ $data->getStatusOrder->value  ?? 'N/A' }} </span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Status Package:</strong>
                                <span class="badge badge-info" style="font-size: 20px;"> {{ $data->getStatusPackage->value  ?? 'N/A' }} </span>
                            </div>
                        </li>
                    </ul>
                </div>


            </div>
        </div>
    </div>
</div>

<div class="card-footer">
    <a href="{{ route('b2b.api_orders.index') }}" class="btn btn-secondary">Back to List</a>
</div>

@endsection
