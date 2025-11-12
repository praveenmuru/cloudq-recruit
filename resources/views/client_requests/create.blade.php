@extends('adminlte::page')

@section('title', 'Add Client Request')

@section('content_header')
    <h1>Add Client Request</h1>
@stop

@section('content')
<form action="{{ route('client-requests.store') }}" method="POST">
    @csrf
    @include('client_requests.form')
    <button class="btn btn-success mt-3">Save</button>
</form>
@stop
