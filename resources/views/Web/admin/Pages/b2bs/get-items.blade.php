@extends('layouts.master')

@section('title', 'Admin Dashboard')
@section('title_page', 'B2Bs')

@section('content')
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">




                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <h1 class="mb-4"> List Items of b2b </h1>
                <div class="row ">
                    <form action="{{ route('admin.b2bs.getItems') }}" method="GET" class="d-flex align-items-end w-100">
                        @csrf
                        <input id="id" type="hidden" name="id" class="form-control" value="{{ request('id') }}">
                        <div class="col-3">
                            <label for="sub_category_id" class="form-label">Main Category</label>
                            <select class="select2 form-select"  style="width: 100%" id="sub_category_id" name="sub_category_id">
                                <option class="text-center"  value="" selected> All </option>
                                @if(!empty($categories))
                                    @foreach($categories as $category)
                                        <option class="text-center" value="{{ $category->id }}" {{ request('sub_category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-2">
                            <button type="submit" class="btn btn-primary" style="margin-bottom: -2px;">Filter</button>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                <table id="datatable" class="table  table-hover table-sm table-bordered p-0 tableC">
                <thead>
                        <tr>
                            <th> # </th>
                            <th> Main Category </th>
                            <th> Capacity </th>
                            <th> Plan Type </th>
                            <th> Validity </th>
                            <th> Status </th>
                            <th> Cost Price </th>
                            <th> Final Price </th>
                            <th> Retail Price </th>
                            <th> Created At </th>
                            <th> Updated At </th>
                            <th> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($datas as $index => $item)
                            <tr>
                                <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                                <td>{{ $item->getSubCategory->name ?? 'N/A' }}</td>
                                <td>{{ $item->capacity ?? 'N/A' }}</td>
                                <td>{{ $item->plan_type ?? 'N/A' }}</td>
                                <td>{{ $item->validaty ?? 'N/A' }}</td>
                                <td>
                                    @if($item->status)
                                        <span class="btn btn-sm btn-outline-success round">Enable   </span>
                                    @else
                                        <span class="btn btn-sm btn-outline-danger round">Disable  </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="price-container">
                                        <span class="currency-symbol">$</span>
                                        <span class="price-amount">{{ number_format($item->getItemSource->cost_price, 2) }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="price-container">
                                        <span class="currency-symbol">$</span>
                                        <span class="price-amount">{{ number_format($item->getItemSource->getPaymentPrice[0]->final_price, 2) }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="price-container">
                                        <span class="currency-symbol">$</span>
                                        <span class="price-amount">{{ number_format($item->getItemSource->retail_price, 2) }}</span>
                                    </div>
                                </td>
                                <td>{{ formatDate($item->created_at) ?? 'N/A'  }}</td>
                                <td>{{ formatDate($item->updated_at) ?? 'N/A'  }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu dropdownMenuC" aria-labelledby="dropdownMenuButton" style="width: 184%;"  >
                                            <form action="{{ route('admin.items.show') }}" method="GET" class="formC" >
                                                @csrf
                                                <input id="id" type="hidden" name="id" class="form-control" value="{{ $item->id }}">
                                                <button type="submit" class="dropdown-item d-flex justify-content-between align-items-center">
                                                    Show <i class="fa fa-eye"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No data available.</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
                <div class="mt-4 d-flex justify-content-center">
                    {{ $datas->links('pagination::bootstrap-4') }}
                </div>

                </div>





            </div>
        </div>
    </div>
</div>
@endsection
