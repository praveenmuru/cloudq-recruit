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

         <form method="GET" action="{{ route('interviews.index') }}" class="mb-4">
            <div class="row">
                <div class="col-md-2">
                    <input type="text" name="client_name" value="{{ request('client_name') }}" class="form-control" placeholder="Client Name">
                </div>

                <div class="col-md-2">
                    <input type="text" name="role" value="{{ request('role') }}" class="form-control" placeholder="Role">
                </div>

                <div class="col-md-2">
                    <select name="cv_status" class="form-control">
                        <option value="">CV Status</option>
                        <option value="Shortlisted" {{ request('cv_status')=='Shortlisted' ? 'selected':'' }}>Shortlisted</option>
                        <option value="Rejected" {{ request('cv_status')=='Rejected' ? 'selected':'' }}>Rejected</option>
                        <option value="Pending" {{ request('cv_status')=='Pending' ? 'selected':'' }}>Pending</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="interview_status" class="form-control">
                        <option value="">Interview Status</option>
                        <option value="Selected" {{ request('interview_status')=='Selected' ? 'selected':'' }}>Selected</option>
                        <option value="Rejected" {{ request('interview_status')=='Rejected' ? 'selected':'' }}>Rejected</option>
                        <option value="Pending" {{ request('interview_status')=='Pending' ? 'selected':'' }}>Pending</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="offer_status" class="form-control">
                        <option value="">Offer Status</option>
                        <option value="Offered" {{ request('offer_status')=='Offered' ? 'selected':'' }}>Offered</option>
                        <option value="Not Offered" {{ request('offer_status')=='Not Offered' ? 'selected':'' }}>Not Offered</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                </div>

                <div class="col-md-2 mt-2">
                    <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                </div>

                <div class="col-md-2 mt-2">
                    <button type="submit" class="btn btn-success btn-block">Filter</button>
                </div>

                <div class="col-md-2 mt-2">
                    <a href="{{ route('interviews.index') }}" class="btn btn-secondary btn-block">Reset</a>
                </div>
            </div>
        </form>

        <div class="mb-3">
    <a href="{{ route('interviews.index', ['cv_status'=>'Shortlisted']) }}" class="btn btn-outline-primary btn-sm">Shortlisted</a>
    <a href="{{ route('interviews.index', ['interview_status'=>'Selected']) }}" class="btn btn-outline-success btn-sm">Selected</a>
    <a href="{{ route('interviews.index', ['offer_status'=>'Offered']) }}" class="btn btn-outline-info btn-sm">Offered</a>
</div>


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
