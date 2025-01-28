@extends('layouts.master')

@section('title', 'Admin Dashboard')
@section('title_page', 'Countries')

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

                <h1 class="mb-4"> Countries </h1>
                <br />
                <div class="row">
                    <a href="{{ route('admin.countries.create') }}" class="btn btn-success text-center AddButtonC" >Add Country</a>
                </div>


                <div class="table-responsive">
                <table id="datatable" class="table  table-hover table-sm table-bordered p-0 tableC">
                <thead>
                        <tr>
                            <th> # </th>
                            <th> Name EN</th>
                            <th> Name AR</th>
                            <th> Flag </th>
                            <th> Code </th>
                            <th> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($datas as $index => $item)
                            <tr>
                                <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                                <td>{{ $item->name_en ?? 'N/A' }}</td>
                                <td>{{ $item->name_ar ?? 'N/A' }}</td>
                                <td>
                                    @if($item['flag'])
                                        <img src="{{ $item['flag'] }}" alt="{{ $item['name_en'] }}" width="110" height="60">
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td>{{ $item->code ?? 'N/A' }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu dropdownMenuC" aria-labelledby="dropdownMenuButton" >
                                            <form action="{{ route('admin.countries.edit') }}" method="GET" class="formC" >
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

                                            <form action="{{ route('admin.countries.delete') }}" method="POST">
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
