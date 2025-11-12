@extends('adminlte::page')

@section('title','New Candidate')

@section('content_header')
    <h1>New Candidate</h1>
@stop

@section('content')
    @include('candidates._form', [
        'action' => route('candidates.store'),
        'method' => null,
    ])
@stop
