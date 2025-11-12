@extends('adminlte::page')

@section('title', 'Edit Interview')

@section('content_header')
    <h1>Edit Interview</h1>
@stop

@section('content')
<form action="{{ route('interviews.update', $interview) }}" method="POST">
    @csrf @method('PUT')
    @include('interviews.form')
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@stop
