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

<form method="GET" class="mb-4">
    <div class="row">

        <div class="col-md-3">
            <label>Client</label>
            <select name="client_id" class="form-control select2">
                <option value="">All</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                        {{ $client->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label>Role</label>
            <select name="role_id" class="form-control select2">
                <option value="">All</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label>Skills</label>
            <select name="skills[]" class="form-control select2" multiple>
                @foreach($skills as $skill)
                    <option value="{{ $skill->id }}"
                        @if(request()->skills && in_array($skill->id, request()->skills)) selected @endif>
                        {{ $skill->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label>Locations</label>
            <select name="locations[]" class="form-control select2" multiple>
                @foreach($locations as $loc)
                    <option value="{{ $loc->id }}"
                        @if(request()->locations && in_array($loc->id, request()->locations)) selected @endif>
                        {{ $loc->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-2 mt-3">
            <label>From Date</label>
            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
        </div>

        <div class="col-md-2 mt-3">
            <label>To Date</label>
            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
        </div>

        <div class="col-md-2 mt-4">
            <button class="btn btn-primary mt-2">Filter</button>
        </div>

        <div class="col-md-2 mt-4">
            <a href="{{ route('client-requests.index') }}" class="btn btn-secondary mt-2">Reset</a>
        </div>

    </div>
</form>


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

@push('js')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
$('.select2').select2({
    tags: true,
    width: '100%'
});
</script>
@endpush


@stop
