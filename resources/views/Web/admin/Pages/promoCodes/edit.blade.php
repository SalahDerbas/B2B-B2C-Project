@extends('layouts.master')

@section('title', 'Admin Dashboard')
@section('title_page', 'Promo Codes')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="card-header">
                        <h3>Edit Promo Code</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.promo_codes.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="id" name="id" value="{{ $data['id'] }}" />

                            <div class="row">
                                <div class="col-md-4">
                                    <label for="promo_code">Promo Code</label><br />
                                    <input type="text" id="promo_code" name="promo_code" value="{{ $data['promo_code'] }}" class="@error('promo_code') is-invalid @enderror" required>
                                    @error('promo_code')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-4">
                                    <label for="description">Description</label><br />
                                    <input type="text" id="description" name="description" value="{{ $data['description'] }}" class="@error('description') is-invalid @enderror" required>
                                    @error('description')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-4">
                                    <label for="limit">Limit</label><br />
                                    <input type="number" id="limit" name="limit" min="1" value="{{ $data['limit'] }}" class="@error('limit') is-invalid @enderror" required>
                                    @error('limit')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-4">
                                    <label for="user_limit">User Limit</label><br />
                                    <input type="number" id="user_limit" name="user_limit" min="1" value="{{ $data['user_limit'] }}" class="@error('user_limit') is-invalid @enderror" required>
                                    @error('user_limit')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-4">
                                    <label for="amount">Amount</label><br />
                                    <input type="number" id="amount" name="amount" step="0.0001" min="0.0001" value="{{ $data['amount'] }}" class="@error('amount') is-invalid @enderror" required>
                                    @error('amount')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-4">
                                    <label for="from_date">Start Date</label><br />
                                    <input type="date" id="from_date" name="from_date" value="{{ old('from_date', formatDate($data['from_date']) ) }}" required>
                                    @error('from_date')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-4">
                                    <label for="to_date">End Date</label><br />
                                    <input type="date" id="to_date" name="to_date" value="{{ old('to_date', formatDate($data['to_date']) ) }}" required>
                                    @error('to_date')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="type_id">Type</label><br />
                                    <select class="select2 form-select"  style="width: 100%" id="type_id" name="type_id">
                                        <option class="text-center"  value="" selected></option>
                                        @if(!empty($types))
                                            @foreach($types as $type)
                                                <option class="text-center" value="{{ $type->id }}"  {{ $data['type_id'] == $type->id ? 'selected' : '' }}>
                                                    {{ $type->value }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>

                                    @error('type_id')
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
        <a href="{{ route('admin.promo_codes.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

@endsection

<script>


    function validateDate() {

        var startDate = document.getElementById('from_date').value;
        var endDate = document.getElementById('to_date').value;

        if (startDate && endDate && new Date(endDate) < new Date(startDate)) {
          alert("End date must be after the start date.");
          document.getElementById('to_date').value = '';
        }
      }

</script>
