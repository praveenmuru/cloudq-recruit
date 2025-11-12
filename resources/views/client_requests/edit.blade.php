@extends('adminlte::page')

@section('title', 'Edit Client Request')

@section('content_header')
    <h1>Edit Client Request</h1>
@stop

@section('content')
<form action="{{ route('client-requests.update', $clientRequest) }}" method="POST">
    @csrf
    @method('PUT')
    @include('client_requests.form', ['clientRequest' => $clientRequest])
    <button class="btn btn-primary mt-3">Update</button>
</form>
@stop
