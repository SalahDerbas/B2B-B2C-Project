@extends('layouts.master')

@section('title', 'B2B Dashboard')
@section('title_page', 'Manage Esim')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-statistics h-100">
            <div class="card-body">

                <div class="card-header">
                    <h3>E-sim Details</h3>
                </div>
                <div class="card-body">
                    <h4>{{ $data->getSubCategory->name ?? 'N/A' }}</h4>
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Name:</strong>
                                <span>{{ $data->getSubCategory->name ?? 'N/A' }}</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Capacity:</strong>
                                <span>{{ $data->capacity ?? 'N/A' }}</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Plan Type:</strong>
                                <span>{{ $data->plan_type ?? 'N/A' }}</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Color:</strong>
                                <span>{{ $data->getSubCategory->color ?? 'N/A' }}</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Price:</strong>
                                <span>${{ number_format($data->getItemSource->getPaymentPriceB2b->final_price ?? 0, 2) }}</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Validity:</strong>
                                <span>{{ $data->validaty ?? 'N/A' }}</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Created At:</strong>
                                <span>{{ \Carbon\Carbon::parse($data->created_at)->format('Y-m-d') }}</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Updated At:</strong>
                                <span>{{ \Carbon\Carbon::parse($data->updated_at)->format('Y-m-d') }}</span>
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
                    <h3>E-sim Media and Details</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Photo:</strong>
                                <span><img src="{{$data->getSubCategory->photo}}" width="150" height="100" /></span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <strong>Cover:</strong>
                                <span><img src="{{$data->getSubCategory->cover}}" width="150" height="100" /></span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="">
                                <strong>Coverages:</strong>
                                <span>
                                    @if (isset($data->coverages))
                                        <ul>

                                            @foreach (json_decode($data->coverages) as $coverage)


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
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card-footer">
    <a href="{{ route('b2b.manage_esims.index') }}" class="btn btn-secondary">Back to List</a>
</div>

@endsection
