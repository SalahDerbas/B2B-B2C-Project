@extends('layouts.master')

@section('title', 'Admin Dashboard')
@section('title_page', 'Category')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="card-header">
                        <h3>Create Category</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name">Name</label><br />
                                    <input type="text" id="name" name="name" class="@error('name') is-invalid @enderror" required>
                                    @error('name')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="description">Description</label><br />
                                    <input type="text" id="description" name="description" class="@error('description') is-invalid @enderror">
                                    @error('description')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-4">
                                    <label for="color">Color</label><br />
                                    <input type="text" id="color" name="color" class="@error('color') is-invalid @enderror">
                                    @error('color')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-4">
                                    <label for="photo">Photo</label><br />
                                    <input type="file" id="photo" name="photo" class="@error('photo') is-invalid @enderror" >
                                    @error('photo')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="cover">Cover</label><br />
                                    <input type="file" id="cover" name="cover" class="@error('cover') is-invalid @enderror">
                                    @error('cover')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

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
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

@endsection
