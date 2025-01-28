@extends('layouts.master')

@section('title', 'Admin Dashboard')
@section('title_page', 'Items')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="card-header">
                        <h3>Update Item</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.items.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="id" name="id" value="{{ $data['id'] }}" />
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="sub_category_id">Category</label><br />
                                    <select class="select2 form-select"  style="width: 100%" id="sub_category_id" name="sub_category_id">
                                        <option class="text-center"  value="" selected></option>
                                        @if(!empty($categories))
                                            @foreach($categories as $category)
                                                <option class="text-center" value="{{ $category->id }}" {{ $data['sub_category_id'] == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>

                                    @error('sub_category_id')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="source_id">Source</label><br />
                                    <select class="select2 form-select"  style="width: 100%" id="source_id" name="source_id">
                                        <option class="text-center"  value="" selected></option>
                                        @if(!empty($sources))
                                            @foreach($sources as $source)
                                                <option class="text-center" value="{{ $source->id }}" {{ $data['getItemSource']['source_id'] == $source->id ? 'selected' : '' }}>
                                                    {{ $source->name }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>

                                    @error('sub_category_id')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="capacity">Capacity</label><br />
                                    <input type="text" id="capacity" name="capacity" value="{{ $data['capacity'] }}" class="@error('capacity') is-invalid @enderror" required>
                                    @error('capacity')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="plan_type">Plan Type</label><br />
                                    <input type="text" id="plan_type" name="plan_type" value="{{ $data['plan_type'] }}" class="@error('plan_type') is-invalid @enderror" required>
                                    @error('plan_type')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="validaty">Validaty</label><br />
                                    <input type="text" id="validaty" name="validaty" value="{{ $data['validaty'] }}" class="@error('validaty') is-invalid @enderror" required>
                                    @error('validaty')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="package_id">Package ID</label><br />
                                    <input type="text" id="package_id" name="package_id" value="{{ $data['getItemSource']['package_id'] }}"  class="@error('package_id') is-invalid @enderror" required>
                                    @error('package_id')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="cost_price">Cost Price</label><br />

                                    <input type="number" id="cost_price" name="cost_price" value="{{ $data['getItemSource']['cost_price'] }}" step="0.0001" min="0" class="@error('cost_price') is-invalid @enderror" required>
                                    @error('cost_price')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="retail_price">Retail Price</label><br />
                                    <input type="number" id="retail_price" name="retail_price" value="{{ $data['getItemSource']['retail_price'] }}"  step="0.0001" min="0" class="@error('retail_price') is-invalid @enderror" required>
                                    @error('retail_price')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

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
        <a href="{{ route('admin.items.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

@endsection
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function () {
      // When the "Add Item" button is clicked
      $("#add-item").on("click", function () {

        // Clone the hidden template
        const newItem = $(".repeater-item:first").clone().show();

        // Append the cloned item to the container
        $("#repeater-container").append(newItem);
      });

      // When the "Remove" button is clicked
      $(document).on("click", ".remove-item", function () {
        $(this).closest(".repeater-item").remove();
      });
    });
  </script>
