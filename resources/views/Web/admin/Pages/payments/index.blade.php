@extends('layouts.master')

@section('title', 'Admin Dashboard')
@section('title_page', 'Payments')

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

                <h1 class="mb-4"> Payments </h1>

                <div class="row">
                    <form action="{{ route('admin.payments.index') }}" method="GET" class="d-flex align-items-end w-100">
                        <div class="col-3">
                            <label for="category_id" class="form-label">Is B2B</label>
                            <select class="select2 form-select"  style="width: 100%" id="is_b2b" name="is_b2b">
                                <option class="text-center" value=""  {{ is_null(request('is_b2b')) ? 'selected' : '' }}>All</option>
                                <option class="text-center" value="0" {{ request('is_b2b') == 0 ? 'selected' : '' }}>False</option>
                                <option class="text-center" value="1" {{ request('is_b2b') == 1 ? 'selected' : '' }}>True</option>
                      </select>
                        </div>

                        <div class="col-2">
                            <button type="submit" class="btn btn-primary" style="margin-bottom: -2px;">Filter</button>

                        </div>
                    </form>
                </div>

                <br />
                <div class="row">
                    <a href="{{ route('admin.payments.create') }}" class="btn btn-success text-center AddButtonC" >Add Payment</a>
                </div>


                <div class="table-responsive">
                <table id="datatable" class="table  table-hover table-sm table-bordered p-0 tableC">
                <thead>
                        <tr>
                            <th> # </th>
                            <th> Name </th>
                            <th> Photo </th>
                            <th> Status </th>
                            <th> IS B2B </th>
                            <th> Created At </th>
                            <th> Updated At </th>
                            <th> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($datas as $index => $item)
                            <tr>
                                <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                                <td>{{ $item->name ?? 'N/A' }}</td>
                                <td>
                                    @if($item['photo'])
                                        <img src="{{ $item['photo'] }}" alt="{{ $item['name'] }}" width="110" height="60">
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>
                                    @if($item->status)
                                        <span class="btn btn-sm btn-outline-success round">Active   </span>
                                    @else
                                        <span class="btn btn-sm btn-outline-danger round">Block  </span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->is_b2b)
                                        <span class="btn btn-sm btn-outline-success round">Yes   </span>
                                    @else
                                        <span class="btn btn-sm btn-outline-danger round">No  </span>
                                    @endif

                                </td>
                                <td>{{ formatDate($item->created_at) ?? 'N/A'  }}</td>
                                <td>{{ formatDate($item->updated_at) ?? 'N/A'  }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu dropdownMenuC" aria-labelledby="dropdownMenuButton" >
                                            <form action="{{ route('admin.payments.edit') }}" method="GET" class="formC" >
                                                @csrf
                                                <input id="id" type="hidden" name="id" class="form-control" value="{{ $item->id }}">
                                                <button type="submit" class="dropdown-item d-flex justify-content-between align-items-center">
                                                    Edit <i class="fa fa-edit"></i>
                                                </button>
                                            </form>

                                            <a class="dropdown-item d-flex justify-content-between align-items-center" data-toggle="modal" data-target="#delete{{ $item->id }}" >Delete <i class="fa fa-trash"></i></a>
                                            <form action="{{ route('admin.payments.switchStatus') }}" method="GET" class="formC" >
                                                @csrf
                                                <input id="id" type="hidden" name="id" class="form-control" value="{{ $item->id }}">
                                                <button type="submit" class="dropdown-item d-flex justify-content-between align-items-center">
                                                    @if($item->status)  Disable @else  Enable @endif
                                                    <i class="fa fa-ban" aria-hidden="true"></i>
                                                </button>
                                            </form>
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

                                            <form action="{{ route('admin.payments.delete') }}" method="POST">
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
