@extends('layouts.master')

@section('title', 'Admin Dashboard')
@section('title_page', 'Promo Codes')

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

                <h1 class="mb-4"> Promo Codes </h1>

                <div class="row">
                    <form action="{{ route('admin.promo_codes.index') }}" method="GET" class="d-flex align-items-end w-100">
                        <div class="col-3">
                            <label for="type_id" class="form-label">Type</label><br />
                            <select class="form-select" id="type_id" name="type_id" style="width: 100%">
                                <option class="text-center"  value="" selected>All</option>
                                @if(!empty($types))
                                    @foreach($types as $type)
                                        <option class="text-center" value="{{ $type->id }}" {{ request('type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->value }}
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

                <br />
                <div class="row">
                    <a href="{{ route('admin.promo_codes.create') }}" class="btn btn-success text-center AddButtonC" >Add Promo Code</a>
                </div>


                <div class="table-responsive">
                <table id="datatable" class="table  table-hover table-sm table-bordered p-0 tableC">
                <thead>
                        <tr>
                            <th> # </th>
                            <th> Promo Code </th>
                            <th> Description </th>
                            <th> Type </th>
                            <th> From Date </th>
                            <th> To Date </th>
                            <th> Limit </th>
                            <th> User Limit </th>
                            <th> Counter </th>
                            <th> Amount </th>
                            <th> Created At </th>
                            <th> Updated At </th>
                            <th> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($datas as $index => $item)
                            <tr>
                                <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                                <td>{{ $item->promo_code ?? 'N/A' }}</td>
                                <td>{{ $item->description ?? 'N/A' }}</td>
                                <td>{{ $item->getType->value ?? 'N/A' }}</td>
                                <td>{{ formatDate($item->from_date) ?? 'N/A'  }}</td>
                                <td>{{ formatDate($item->to_date) ?? 'N/A'  }}</td>
                                <td>{{ $item->limit ?? 'N/A' }}</td>
                                <td>{{ $item->user_limit ?? 'N/A' }}</td>
                                <td>{{ $item->counter ?? 'N/A' }}</td>
                                <td>{{ $item->amount ?? 'N/A' }}</td>
                                <td>{{ formatDate($item->created_at) ?? 'N/A'  }}</td>
                                <td>{{ formatDate($item->updated_at) ?? 'N/A'  }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu dropdownMenuC" aria-labelledby="dropdownMenuButton" >
                                            <form action="{{ route('admin.promo_codes.edit') }}" method="GET" class="formC" >
                                                @csrf
                                                <input id="id" type="hidden" name="id" class="form-control" value="{{ $item->id }}">
                                                <button type="submit" class="dropdown-item d-flex justify-content-between align-items-center">
                                                    Edit <i class="fa fa-edit"></i>
                                                </button>
                                            </form>

                                            <a class="dropdown-item d-flex justify-content-between align-items-center" data-toggle="modal" data-target="#delete{{ $item->id }}" >Delete <i class="fa fa-trash"></i></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="delete{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title modalTitleC" id="exampleModalLabel">
                                                Delete Admin
                                            </h5>
                                        </div>
                                        <div class="modal-body">
                                            Are Sure Of The Deleting Process ?

                                            <form action="{{ route('admin.promo_codes.delete') }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input id="id" type="hidden" name="id" class="form-control" value="{{ $item->id }}">
                                                <div class="modal-footer modelFooterC">
                                                    <a type="button" class="closeButtonC btn btn-secondary" data-dismiss="modal" > Close </a>
                                                    <button type="submit" class="btn btn-danger submitButtonC"> Submit </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
