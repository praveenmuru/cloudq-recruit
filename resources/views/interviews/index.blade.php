@extends('adminlte::page')

@section('title', 'Interviews')

@section('content_header')
    <h1>Interview List</h1>
@stop

@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('interviews.create') }}" class="btn btn-primary">Add New Interview</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Role</th>
                    <th>Candidate</th>
                    <th>CV Status</th>
                    <th>Interview Date</th>
                    <th>Interview Time</th>
                    <th>Round</th>
                    <th>Interview Status</th>
                    <th>Offer Status</th>
                    <th>Offered Salary</th>
                    <th>Joining Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($interviews as $interview)
                <tr>
                    <td>{{ $interview->client_name }}</td>
                    <td>{{ $interview->role }}</td>
                    <td>{{ $interview->candidate_name }}</td>
                    <td>{{ $interview->cv_status }}</td>
                    <td>{{ $interview->interview_date }}</td>
                    <td>{{ $interview->interview_time }}</td>
                    <td>{{ $interview->client_round }}</td>
                    <td>{{ $interview->interview_status }}</td>
                    <td>{{ $interview->offer_status }}</td>
                    <td>{{ $interview->offered_salary }}</td>
                    <td>{{ $interview->joining_date }}</td>
                    <td>
                        <a href="{{ route('interviews.edit', $interview) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('interviews.destroy', $interview) }}" method="POST" style="display:inline-block">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $interviews->links() }}
    </div>
</div>
@stop
