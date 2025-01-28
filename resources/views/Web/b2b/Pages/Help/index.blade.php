@extends('layouts.master')

@section('title', 'B2B Dashboard')
@section('title_page', 'Help')

<style>
.faq-item {
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
    margin-bottom: 10px;
}

.faq-question {
    font-weight: bold;
    color: #007bff;
    transition: color 0.2s ease-in-out;
}

.faq-question:hover {
    color: #0056b3;
    text-decoration: underline;
}

.faq-answer {
    margin-top: 10px;
    color: #555;
}

</style>


@section('content')
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <h1 class="text-center mb-4">FAQ</h1>
                <div class="faq-section">
                    @forelse ($datas as $index => $item)
                        <div class="faq-item mb-3">
                            <h6 class="faq-question" style="cursor: pointer;">{{ $item['question'] }}</h6>
                            <div class="faq-answer" style="display: none;">
                                <p>{{ $item['answer'] }}</p>
                            </div>
                        </div>
                    @empty
                        <h4>No data available</h4>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function() {
        // Toggle the visibility of the answer when the question is clicked
        $(".faq-question").click(function() {
            $(this).next(".faq-answer").slideToggle();
        });
    });
</script>
