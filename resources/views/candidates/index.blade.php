@extends('adminlte::page')

@section('title', 'Candidates')

@section('content_header')
    <h1>Candidates</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <form class="form-inline" method="GET" action="{{ route('candidates.index') }}">
            <input type="text" name="name" class="form-control mr-2" placeholder="Name" value="{{ request('name') }}">
            <input type="text" name="client" class="form-control mr-2" placeholder="Client" value="{{ request('client') }}">
            <input type="text" name="keyword" class="form-control mr-2" placeholder="Keyword" value="{{ request('keyword') }}">
            <button class="btn btn-primary mr-2">Filter</button>
            <a href="{{ route('candidates.index') }}" class="btn btn-default">Reset</a>
        </form>

        <a href="{{ route('candidates.create') }}" class="btn btn-success">New Candidate</a>
    </div>

    <div class="card-body table-responsive p-0">
        @if(session('success'))
            <div class="alert alert-success m-3">{{ session('success') }}</div>
        @endif

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Title</th>
                    <th>Client</th>
                    <th>Keywords</th>
                    <th>Location</th>
                    <th>Work Type</th>
                    <th>CTC/ ECTC</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($candidates as $candidate)
                    <tr>
                        <td>{{ $candidate->id }}</td>
                        <td>{{ $candidate->name }}</td>
                        <td>{{ $candidate->title }}</td>
                        <td>{{ $candidate->client }}</td>
                        <td>{{ $candidate->keywordsString() }}</td>
                        <td>{{ $candidate->location }}</td>
                        <td>{{ $candidate->work_type }}</td>
                        <td>{{ $candidate->ctc ?? '-' }} / {{ $candidate->ectc ?? '-' }}</td>
                        <td>{{ optional($candidate->date_of_joining)->format('Y-m-d') ?? '-' }}</td>
                        <td>
                            <a href="{{ route('candidates.show', $candidate) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('candidates.edit', $candidate) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('candidates.destroy', $candidate) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Delete candidate?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="10" class="text-center">No candidates found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer">
        {{ $candidates->links() }}
    </div>
</div>
@stop
