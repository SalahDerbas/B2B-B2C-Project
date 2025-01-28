@extends('layouts.master')

@section('title', 'Admin Dashboard')
@section('title_page', 'B2Bs')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="card-header">
                        <h3>Create B2B</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('admin.b2bs.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="username">User Name</label><br />
                                    <input type="text" id="username" name="username" class="@error('username') is-invalid @enderror" required>
                                    @error('username')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="name">Name</label><br />
                                    <input type="text" id="name" name="name" class="@error('name') is-invalid @enderror" required>
                                    @error('name')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="email">Email</label><br />
                                    <input type="email" id="email" name="email" class="@error('email') is-invalid @enderror" required>
                                    @error('email')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="password">Password</label><br />
                                    <input type="password" id="password" name="password" class="@error('password') is-invalid @enderror" required>
                                    @error('password')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <label for="b2b_balance">Balance</label><br />
                                    <input type="number" id="b2b_balance" name="b2b_balance" step="0.0001" min="0" class="@error('b2b_balance') is-invalid @enderror" required>
                                    @error('b2b_balance')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-12">
                                    <label for="country_id">Operaters</label><br />
                                    <div id="repeater-container">
                                        <div data-repeater-list="percentage-name-data">

                                            <div class="row g-3 mb-3 repeater-item" data-repeater-item >
                                                <div class="col-md-3">
                                                    <input type="text" name="operaters[]" class="form-control" placeholder="Operater Name" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="number" name="values[]" step="0.0001" min="0" class="form-control" placeholder="Operater Value" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <select class="select2 form-select" style="width: 100%" id="types" name="types[]">
                                                        <option class="text-center" value="" selected>Select Type</option>
                                                        @if (!empty($types))
                                                            @foreach ($types as $type)
                                                                <option class="text-center" value="{{ $type->id }}">
                                                                    {{ $type->value }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <button id="add-item" data-repeater-create class="btn btn-primary" style="width:auto;"><i class="fa fa-plus"></i></button>
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
        <a href="{{ route('admin.b2bs.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

@endsection


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const repeaterContainer = document.querySelector("#repeater-container [data-repeater-list='percentage-name-data']");

        // Add Network Button
        document.getElementById("add-item").addEventListener("click", function (e) {
            e.preventDefault(); // Prevent form submission

            // Create a new repeater item
            const newItem = document.createElement("div");
            newItem.classList.add("row", "g-3", "mb-3", "repeater-item");
            newItem.innerHTML = `
                    <div class="col-md-3">
                        <input type="text" name="operaters[]" class="form-control" placeholder="Operater Name" required>
                    </div>
                    <div class="col-md-4">
                        <input type="number" name="values[]" step="0.0001" min="0"  class="form-control" placeholder="Operater Value" required>
                    </div>
                    <div class="col-md-4">
                        <select class="select2 form-select"  style="width: 100%" id="types" name="types[]">
                            <option class="text-center"  value="" selected> Select Type </option>
                            @if(!empty($types))
                                @foreach($types as $type)
                                    <option class="text-center" value="{{ $type->id }}">
                                        {{ $type->value }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-1">
                    <button class="btn btn-danger remove-item"><i class="fa fa-close"></i></button>
                    </div>
            `;

            // Append the new item to the repeater list
            repeaterContainer.appendChild(newItem);
        });

        // Handle Remove Button Click
        repeaterContainer.addEventListener("click", function (e) {
            if (e.target && (e.target.classList.contains("remove-item") || e.target.closest(".remove-item"))) {
                e.preventDefault();
                e.target.closest(".repeater-item").remove();
            }
        });
        });
    </script>
