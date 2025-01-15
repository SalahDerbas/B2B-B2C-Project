@extends('layouts.master')

@section('title', 'B2B Dashboard')
@section('title_page', 'API Integration')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-statistics h-100">
            <div class="card-body">
                    <div class="col-md-6 border-right-2 border-right-blue-400">
                        <div class="form-group row">
                            <div class="col-lg-9">
                                <div class="alert alert-warning mt-3" role="alert">
                                    <strong>⚠️ Never share your API credentials with untrusted parties.</strong>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">API Client ID </label><br />
                                <div class="col-lg-9">
                                        <div class="input-group">
                                            <input value="{{ $data['client_id'] }}" type="text" class="form-control" id="apiClientId"  readonly>
                                            <button class="btn btn-outline-secondary" onclick="copyToClipboard('apiClientId')">
                                                <i class="bi bi-clipboard"></i>
                                            </button>
                                        </div>
                                </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label font-weight-semibold">API Client Secret </label><br />
                                <div class="col-lg-9">
                                        <div class="input-group">
                                            <input value="{{ $data['client_secret'] }}" type="text" class="form-control" id="apiClientSecret"  readonly>
                                            <button class="btn btn-outline-secondary" onclick="copyToClipboard('apiClientSecret')">
                                                <i class="bi bi-clipboard"></i>
                                            </button>
                                        </div>
                                </div>
                        </div>

                    </div>
            </div>
        </div>
    </div>
</div>

@endsection
