@extends('layouts.master')

@section('title', 'Admin Dashboard')
@section('title_page', 'Billings')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-statistics h-100">
            <div class="card-body">

                <div class="card-header">
                    <h3>Billing Details</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Number ID:</strong>
                                <span>{{ $data->number_id ?? 'N/A' }}</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Issue Date:</strong>
                                <span>{{ formatDate($data->issue_date) ?? 'N/A' }}</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Due Date:</strong>
                                <span>{{ formatDate($data->due_date)  ?? 'N/A' }}</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Amount:</strong>
                                <span>{{ $data->amount ?? 'N/A' }}</span>
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
                    <h3>Billing Details</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Payment:</strong>
                                <span><img src="{{$data->getPayment->photo}}" width="150" height="100" /></span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>User/Email:</strong>
                                <span> {{ $data->getUser->email  ?? 'N/A' }} </span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Status:</strong>
                                <span class="badge badge-info" style="font-size: 20px;"> {{ $data->getStatus->value  ?? 'N/A' }} </span>
                            </div>
                        </li>
                    </ul>
                </div>


            </div>
        </div>
    </div>
</div>

<div class="card-footer">
    <a href="{{ route('admin.billings.index') }}" class="btn btn-secondary">Back to List</a>
</div>

@endsection
