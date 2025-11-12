@extends('adminlte::page')

@section('title','Edit Candidate')

@section('content_header')
    <h1>Edit Candidate</h1>
@stop

@section('content')
    @include('candidates._form', [
        'action' => route('candidates.update', $candidate),
        'method' => 'PUT',
        'candidate' => $candidate
    ])
@stop
