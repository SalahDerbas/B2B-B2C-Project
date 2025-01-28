@extends('layouts.master')

@section('title', 'Admin Dashboard')
@section('title_page', 'Payments')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="card-header">
                        <h3>Edit Payment</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.payments.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="id" name="id" value="{{ $data['id'] }}" />

                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name">Name</label><br />
                                    <input type="text" id="name" name="name" value="{{ $data['name']}}" class="@error('name') is-invalid @enderror" required>
                                    @error('name')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-4">
                                    <label for="photo">Photo</label><br />
                                    <input type="file" id="photo" name="photo" class="@error('photo') is-invalid @enderror">
                                    <img src="{{ $data['photo'] }}" alt="{{ $data['name'] }}" width="110" height="60">
                                    @error('photo')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-4">
                                    <label for="is_b2b">Is B2B</label><br />
                                    <select class="select2 form-select"  style="width: 100%" id="is_b2b" name="is_b2b">
                                        <option value="0" {{ $data['is_b2b'] == 0 ? 'selected' : '' }}>False</option>
                                        <option value="1" {{ $data['is_b2b'] == 1 ? 'selected' : '' }}>True</option>
                                      </select>

                                    @error('is_b2b')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

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
        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

@endsection
