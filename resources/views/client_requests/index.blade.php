@extends('adminlte::page')

@section('title', 'Client Requests')

@section('content_header')
    <h1>Client Requests</h1>
@stop

@section('content')
<div class="mb-3">
    <a href="{{ route('client-requests.create') }}" class="btn btn-primary">+ Add New Request</a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Client Name</th>
            <th>Role</th>
            <th>Experience</th>
            <th>Location</th>
            <th>Panel Availability</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($requests as $req)
        <tr>
            <td>{{ $req->id }}</td>
            <td>{{ $req->client_name }}</td>
            <td>{{ $req->role }}</td>
            <td>{{ $req->experience }}</td>
            <td>{{ $req->location }}</td>
            <td>{{ $req->panel_availability }}</td>
            <td>
                <a href="{{ route('client-requests.edit', $req) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('client-requests.destroy', $req) }}" method="POST" style="display:inline-block;">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this request?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $requests->links() }}
@stop
