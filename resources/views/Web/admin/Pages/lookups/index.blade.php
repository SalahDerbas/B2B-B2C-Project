@extends('layouts.master')

@section('title', 'Admin Dashboard')
@section('title_page', 'Lookups')

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

                <h1 class="mb-4"> Lookups </h1>
                <div class="row ">
                    <form action="{{ route('admin.lookups.index') }}" method="GET" class="d-flex align-items-end w-100">
                        <div class="col-3">
                            <label for="code" class="form-label">Code</label>
                            <select class="select2 form-select"  style="width: 100%" id="code" name="code">
                                <option class="text-center"  value="" selected> All </option>
                                @if(!empty($codes))
                                    @foreach($codes as $code)
                                        <option class="text-center" value="{{ $code }}" {{ request('code') == $code ? 'selected' : '' }}>
                                            {{ $code }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-3">
                            <label for="key" class="form-label">Key</label>
                            <select class="select2 form-select"  style="width: 100%" id="key" name="key">
                                <option class="text-center"  value="" selected> All </option>
                                @if(!empty($keys))
                                    @foreach($keys as $key)
                                        <option class="text-center" value="{{ $key }}" {{ request('key') == $key ? 'selected' : '' }}>
                                            {{ $key }}
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
                {{--  <div class="row">
                    <a href="{{ route('admin.lookups.create') }}" class="btn btn-success text-center AddButtonC" >Add Category</a>
                </div>  --}}


                <div class="table-responsive">
                <table id="datatable" class="table  table-hover table-sm table-bordered p-0 tableC">
                <thead>
                        <tr>
                            <th> # </th>
                            <th> Code </th>
                            <th> Key </th>
                            <th> Value </th>
                            <th> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($datas as $index => $item)
                            <tr>
                                <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                                <td>{{ $item->code ?? 'N/A' }}</td>
                                <td>{{ $item->key ?? 'N/A' }}</td>
                                <td>{{ $item->value ?? 'N/A' }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu dropdownMenuC" aria-labelledby="dropdownMenuButton" >
                                            <form action="{{ route('admin.lookups.edit') }}" method="GET" class="formC" >
                                                @csrf
                                                <input id="id" type="hidden" name="id" class="form-control" value="{{ $item->id }}">
                                                <button type="submit" class="dropdown-item d-flex justify-content-between align-items-center">
                                                    Edit <i class="fa fa-edit"></i>
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
