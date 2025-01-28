@extends('layouts.master')

@section('title', 'Admin Dashboard')
@section('title_page', 'Items')


@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="card-header">
                        <h3>Create Item</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.items.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="sub_category_id">Category</label><br />
                                    <select class="select2 form-select"  style="width: 100%" id="sub_category_id" name="sub_category_id">
                                        <option class="text-center"  value="" selected></option>
                                        @if(!empty($categories))
                                            @foreach($categories as $category)
                                                <option class="text-center" value="{{ $category->id }}">
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
                                                <option class="text-center" value="{{ $source->id }}">
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
                                    <input type="text" id="capacity" name="capacity" class="@error('capacity') is-invalid @enderror" required>
                                    @error('capacity')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="plan_type">Plan Type</label><br />
                                    <input type="text" id="plan_type" name="plan_type" class="@error('plan_type') is-invalid @enderror" required>
                                    @error('plan_type')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="validaty">Validaty</label><br />
                                    <input type="text" id="validaty" name="validaty" class="@error('validaty') is-invalid @enderror" required>
                                    @error('validaty')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="package_id">Package ID</label><br />
                                    <input type="text" id="package_id" name="package_id" class="@error('package_id') is-invalid @enderror" required>
                                    @error('package_id')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="cost_price">Cost Price</label><br />

                                    <input type="number" id="cost_price" name="cost_price" step="0.0001" min="0" class="@error('cost_price') is-invalid @enderror" required>
                                    @error('cost_price')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="retail_price">Retail Price</label><br />
                                    <input type="number" id="retail_price" name="retail_price" step="0.0001" min="0" class="@error('retail_price') is-invalid @enderror" required>
                                    @error('retail_price')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                    <div class="col-md-4">
                                        <h4> Coverages </h4>

                                        <label for="country_id">Country</label><br />
                                        <select class="select2 form-select"  style="width: 100%" id="country_id" name="country_id">
                                            <option class="text-center"  value="" selected></option>
                                            @if(!empty($countries))
                                                @foreach($countries as $country)
                                                    <option class="text-center" value="{{ $country->id }}">
                                                        {{ $country->name_en }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>

                                        @error('country_id')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror

                                    </div>
                                    <div class="col-md-4">
                                        <label for="country_id">Network</label><br />
                                        <div id="repeater-container">
                                            <div data-repeater-list="percentage-name-data">

                                            <div class="row g-3 mb-3 repeater-item">
                                              <div class="col-md-8">
                                                <input type="text"  name="networks[]" class="form-control" placeholder="Enter Network" />
                                              </div>
                                              <div class="col-md-4">
                                                <button class="btn btn-danger remove-item">Remove</button>
                                              </div>
                                            </div>
                                          </div>
                                          <button id="add-item" class="btn btn-primary">Add Network</button>
                                        </div>
                                    </div>
                                    </div>

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
