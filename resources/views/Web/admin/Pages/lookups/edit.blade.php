@extends('layouts.master')

@section('title', 'Admin Dashboard')
@section('title_page', 'Lookups')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <div class="card-header">
                    <h3>Update Lookup</h3>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.lookups.update') }}" method="POST">
                        @csrf
                        <div class="row">

                            <input type="hidden" id="id" name="id" value="{{ $data['id'] }}" />
                            <div class="col-md-4">
                                <label for="value"> Value </label><br/>
                                <input type="text" id="value" name="value" value="{{ $data['value'] }}" class="@error('value') is-invalid @enderror" required>
                                @error('value')
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
    <a href="{{ route('admin.lookups.index') }}" class="btn btn-secondary">Back to List</a>
</div>

@endsection
