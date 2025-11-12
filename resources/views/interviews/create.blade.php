@extends('adminlte::page')

@section('title', 'Add Interview')

@section('content_header')
    <h1>Add Interview</h1>
@stop

@section('content')
<form action="{{ route('interviews.store') }}" method="POST">
    @csrf
    @include('interviews.form')
    <button type="submit" class="btn btn-success">Save</button>
</form>
@stop
