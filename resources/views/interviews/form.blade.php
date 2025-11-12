<div class="form-group">
    <label>Client Name</label>
    <input type="text" name="client_name" class="form-control" value="{{ old('client_name', $interview->client_name ?? '') }}" required>
</div>

<div class="form-group">
    <label>Role</label>
    <input type="text" name="role" class="form-control" value="{{ old('role', $interview->role ?? '') }}" required>
</div>

<div class="form-group">
    <label>Candidate Name</label>
    <input type="text" name="candidate_name" class="form-control" value="{{ old('candidate_name', $interview->candidate_name ?? '') }}" required>
</div>

<div class="form-group">
    <label>CV Status</label>
    <select name="cv_status" class="form-control">
        <option value="Pending">Pending</option>
        <option value="Shortlisted">Shortlisted</option>
        <option value="Rejected">Rejected</option>
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
    <select name="interview_status" class="form-control">
        <option value="Pending">Pending</option>
        <option value="Selected">Selected</option>
        <option value="Rejected">Rejected</option>
    </select>
</div>

<div class="form-group">
    <label>Offer Status</label>
    <select name="offer_status" class="form-control">
        <option value="Not Offered">Not Offered</option>
        <option value="Offered">Offered</option>
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
