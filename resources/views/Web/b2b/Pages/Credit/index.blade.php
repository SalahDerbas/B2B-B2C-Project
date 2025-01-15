@extends('layouts.master')

@section('title', 'B2B Dashboard')
@section('title_page', 'Credits')

<style>
    .form-section,
    .summary-section {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        flex: 1;
    }

    h2 {
        margin-bottom: 20px;
        font-size: 1.5rem;
    }

    label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
    }

    input,
    button {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    input.is-invalid {
        border-color: red;
    }

    .error-message {
        color: red;
        font-size: 0.9rem;
        margin-top: -10px;
        margin-bottom: 15px;
    }

    button {
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
    }

    button:hover {
        background-color: #45a049;
    }

    .payment-methods {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }

    .payment-option {
        display: flex;
        align-items: center;
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        cursor: pointer;
        width: calc(50% - 10px);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .payment-option img {
        width: 40px;
        height: 40px;
        margin-right: 10px;
    }

    .payment-option:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .payment-option.selected {
        border-color: #4CAF50;
        background-color: #f0fff0;
    }

    .info-box {
        background-color: #f0f4ff;
        padding: 20px;
        margin-top: 20px;
        border-radius: 5px;
        color: #333;
        width: fit-content;
    }

    .info-box h3 {
        font-size: 1rem;
        margin-bottom: 10px;
    }

    .info-box ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .info-box ul li {
        margin-bottom: 5px;
    }
</style>

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

                    <!-- Form Section -->
                    <div class="form-section">
                        <h2>Add Credits</h2>
                        <form action="{{ route('b2b.credits.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <!-- Amount Field -->
                                <div class="col-md-4">
                                    <ul class="list-group">
                                        <li class="list-group-item">
                                            <label for="amount">Choose an Amount</label>
                                            <input type="number" id="amount" name="amount" placeholder="$ USD"
                                                value="{{ old('amount') }}" class="@error('amount') is-invalid @enderror"
                                                required>
                                            @error('amount')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </li>
                                    </ul>
                                </div>

                                <!-- Payment Method Selection -->
                                <div class="col-md-4">
                                    <label>Select Payment Method</label>
                                    <div class="payment-methods">
                                        @foreach ($datas as $data)
                                            <div class="payment-option @if (old('payment_id') == $data['id']) selected @endif"
                                                data-method="{{ $data['id'] }}"
                                                onclick="selectPaymentMethod({{ $data['id'] }})">
                                                <input type="radio" id="payment_{{ $data['id'] }}" name="payment_id"
                                                    value="{{ $data['id'] }}" hidden
                                                    @if (old('payment_id') == $data['id']) checked @endif required>
                                                <img src="{{ $data['photo'] }}" alt="{{ $data['name'] }}">
                                                <span>{{ $data['name'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('payment_id')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <!-- Info Box Section -->
                                    <div class="info-box">
                                        <h3>How transfer payments work</h3>
                                        <ul>
                                            <li>1. Submit your payment request.</li>
                                            <li>2. You will receive a confirmation email with details.</li>
                                            <li>3. Pay the invoice and forward payment confirmation.</li>
                                            <li>4. Once received, credits will be added to your account.</li>
                                        </ul>
                                    </div>

                                </div>
                            </div>

                            <!-- Submit Button -->
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

    <script>
        function selectPaymentMethod(methodId) {
            document.querySelectorAll('.payment-option').forEach(option => {
                option.classList.remove('selected');
            });
            const selectedOption = document.querySelector(`[data-method="${methodId}"]`);
            selectedOption.classList.add('selected');

            // Check the radio button for the selected payment method
            const radioInput = document.getElementById(`payment_${methodId}`);
            radioInput.checked = true;
        }
    </script>
@endsection
