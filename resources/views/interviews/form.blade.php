<div class="form-group">
    <label>Client Name</label>
<select name="client_id" class="form-control select2">
    @foreach($clients as $id => $name)
        <option value="{{ $id }}">{{ $name }}</option>
    @endforeach
</select></div>

<div class="form-group">
    <label>Role</label>
    <input type="text" name="role" class="form-control" value="{{ old('role', $interview->role ?? '') }}" required>
</div>

<div class="form-group">
    <label>Candidate Name</label>
    <select name="candidate_id" class="form-control select2">
    @foreach($candidates as $id => $name)
        <option value="{{ $id }}">{{ $name }}</option>
    @endforeach
</select>
</div>

<div class="form-group">
    <label>CV Status</label>
   <select name="cv_status" class="form-control select2" required>
    @foreach($cvStatuses as $status)
        <option value="{{ $status->name }}">{{ $status->name }}</option>
    @endforeach
</select>
</div>

<div class="form-group">
    <label>Interview Date</label>
    <input type="date" name="interview_date" class="form-control" value="{{ old('interview_date', $interview->interview_date ?? '') }}">
</div>

<div class="form-group">
    <label>Interview Time</label>
    <input type="time" name="interview_time" class="form-control" value="{{ old('interview_time', $interview->interview_time ?? '') }}">
</div>

<div class="form-group">
    <label>Client Round</label>
    <input type="text" name="client_round" class="form-control" value="{{ old('client_round', $interview->client_round ?? '') }}">
</div>

<div class="form-group">
    <label>Interview Status</label>
   <select name="interview_status" class="form-control select2" required>
    @foreach($interviewStatuses as $status)
        <option value="{{ $status->name }}">{{ $status->name }}</option>
    @endforeach
</select>


</div>

<div class="form-group">
    <label>Offer Status</label>
<select name="offer_status" class="form-control select2" required>
    @foreach($offerStatuses as $status)
        <option value="{{ $status->name }}">{{ $status->name }}</option>
    @endforeach
</select>

</div>

<div class="form-group">
    <label>Offered Salary (LPA)</label>
    <input type="number" step="0.01" name="offered_salary" class="form-control" value="{{ old('offered_salary', $interview->offered_salary ?? '') }}">
</div>

<div class="form-group">
    <label>Joining Date</label>
    <input type="date" name="joining_date" class="form-control" value="{{ old('joining_date', $interview->joining_date ?? '') }}">
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