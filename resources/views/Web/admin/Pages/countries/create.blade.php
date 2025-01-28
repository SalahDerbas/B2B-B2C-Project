@extends('layouts.master')

@section('title', 'Admin Dashboard')
@section('title_page', 'Country')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="card-header">
                        <h3>Create Country</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.countries.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="name_en">Name EN</label><br />
                                    <input type="text" id="name_en" name="name_en" class="@error('name_en') is-invalid @enderror" required>
                                    @error('name_en')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="name_ar">Name AR</label><br />
                                    <input type="text" id="name_ar" name="name_ar" class="@error('name_ar') is-invalid @enderror" required>
                                    @error('name_ar')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-4">
                                    <label for="code">CODE</label><br />
                                    <input type="text" id="code" name="code" class="@error('code') is-invalid @enderror" required>
                                    @error('code')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>


                                <div class="col-md-4">
                                    <label for="photo">Photo</label><br />
                                    <input type="file" id="photo" name="photo" class="@error('photo') is-invalid @enderror" required>
                                    @error('photo')
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
        <a href="{{ route('admin.countries.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

@endsection
