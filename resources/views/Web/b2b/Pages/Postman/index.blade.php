@extends('layouts.master')

@section('title', 'B2B Dashboard')
@section('title_page', 'Postman')

@section('content')
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                <div class="col-md-6 border-right-2 border-right-blue-400">

                    <h1> Environment </h1>
                    <h4 style="color: #0da326"> <strong> Sandbox : </strong></h4>
                    <div class="input-group">
                        <input value="{{env('SANDBOX_URL')}}" type="hidden" class="form-control" id="Sandbox"  readonly>
                        <h3>{{env('SANDBOX_URL')}}
                        <button class="btn btn-outline-secondary" onclick="copyToClipboard('Sandbox')">
                            <i class="bi bi-clipboard"></i>
                        </button>
                        </h3>
                    </div>

                    <br /><br />

                    <h4 style="color: #0da326"> <strong> Production : </strong></h4>
                    <div class="input-group">
                        <input value="{{env('PRODUCTION_URL')}}" type="hidden" class="form-control" id="Production"  readonly>
                        <h3>{{env('PRODUCTION_URL')}}
                        <button class="btn btn-outline-secondary" onclick="copyToClipboard('Production')">
                            <i class="bi bi-clipboard"></i>
                        </button>
                        </h3>
                    </div>
                    <br /><br />

                    <h4 style="color: #0da326">Version :  <span style="color:black"> v1   </span></h4>
                    <br />
                    <div class="row">

                    <a href="{{ route('b2b.run_postman.download', ['version' =>  'v1']) }}" class="btn btn-success">Downlaod Collection Postman</a>
                    </div>

                </div>
        </div>
    </div>
    </div>
</div>
@endsection
