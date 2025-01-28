@extends('layouts.master')

@section('title', 'Admin Dashboard')
@section('title_page', 'B2Bs')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="card-header">
                        <h3>Update Operaters B2B</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.b2bs.updateOperaters') }}" method="POST">
                            @csrf
                            @foreach ($datas as $data )
                            <input type="hidden" id="payment_id" name="payment_id" value="{{ $data['payment_id'] }}" />
                            <input type="hidden" id="id" name="id[]" value="{{ $data['id'] }}" />
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name">Name</label><br />
                                    <input type="text" id="name" name="name[]" value="{{ $data['name'] }}" class="@error('name') is-invalid @enderror" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="value">Value</label><br />
                                    <input type="text" id="value" name="value[]" value="{{ $data['value'] }}" class="@error('value') is-invalid @enderror" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="value">Type</label><br />
                                    <select class="select2 form-select" style="width: 100%" id="type_id" name="type_id[]">
                                        <option class="text-center" value="" selected>Select Type</option>
                                        @if (!empty($types))
                                            @foreach ($types as $type)
                                                <option class="text-center" value="{{ $type->id }}" {{ $data['type_id'] == $type->id ? 'selected' : '' }}>
                                                    {{ $type->value }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                            </div>

                            @endforeach

                            <br />
                            <div class="row" style="display: flex; justify-content: center; align-items: center;">
                                <button type="submit" style="width:auto;">Send Request</button>
                            </div>
                        </form>


                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <a href="{{ route('admin.b2bs.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

@endsection
