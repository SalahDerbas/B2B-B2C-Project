@extends('errors.layout')

@section('error_title', 'Forbidden')
@section('error_code', '403')
@section('error_message', 'Forbidden')
@section('error_description', __($exception->getMessage() ?: 'Forbidden'))
