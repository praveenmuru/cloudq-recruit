@extends('adminlte::page')

@section('title', 'View Client')

@section('content_header')
    <h1>Client Details</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Client Information</h3>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
       
            <tr>
                <th>Name</th>
                <td>{{ $client->name }}</td>
            </tr>
            <tr>
                <th>Point of contact</th>
                <td>{{ $client->point_of_contact }}</td>
            </tr>
            <tr>
                <th>Contact number</th>
                <td>{{ $client->point_of_contact_number }}</td>
            </tr>
        </table>
    </div>
</div>
@stop
