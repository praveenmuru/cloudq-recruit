@extends('adminlte::page')

@section('title', 'Candidate: ' . $candidate->name)

@section('content_header')
    <h1>Candidate Details</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <tbody>
                <tr><th>Name</th><td>{{ $candidate->name }}</td></tr>
                <tr><th>Title</th><td>{{ $candidate->title }}</td></tr>
                <tr><th>Client</th><td>{{ $candidate->client }}</td></tr>
                <tr><th>Keywords</th><td>{{ $candidate->keywordsString() }}</td></tr>
                <tr><th>Phone</th><td>{{ $candidate->phone }}</td></tr>
                <tr><th>Alternate Phone</th><td>{{ $candidate->alternate_phone }}</td></tr>
                <tr><th>Email</th><td>{{ $candidate->email }}</td></tr>
                <tr><th>Current Company</th><td>{{ $candidate->current_company }}</td></tr>
                <tr><th>Current Role</th><td>{{ $candidate->current_role }}</td></tr>
                <tr><th>Total Exp</th><td>{{ $candidate->total_exp }}</td></tr>
                <tr><th>Relevant Exp</th><td>{{ $candidate->relevant_exp }}</td></tr>
                <tr><th>CTC / ECTC</th><td>{{ $candidate->ctc }} / {{ $candidate->ectc }}</td></tr>
                <tr><th>Notice Period</th><td>{{ $candidate->notice_period }}</td></tr>
                <tr><th>Earliest Availability</th><td>{{ $candidate->earliest_availability }}</td></tr>
                <tr><th>Location</th><td>{{ $candidate->location }}</td></tr>
                <tr><th>Preferred Location</th><td>{{ $candidate->preferred_location }}</td></tr>
                <tr><th>Work Type</th><td>{{ $candidate->work_type }}</td></tr>
                <tr><th>Reason For Change</th><td>{{ $candidate->reason_for_job_change }}</td></tr>
                <tr><th>Remarks</th><td>{{ $candidate->remarks }}</td></tr>
                <tr><th>Resume Link</th><td>@if($candidate->resume_link)<a href="{{ $candidate->resume_link }}" target="_blank">Open Resume</a>@endif</td></tr>
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        <a href="{{ route('candidates.edit', $candidate) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('candidates.index') }}" class="btn btn-default">Back</a>
    </div>
</div>
@stop
