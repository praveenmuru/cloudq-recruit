<div class="row">
    <div class="col-md-6">
        <label>Client Name</label>
        <input type="text" name="client_name" value="{{ old('client_name', $clientRequest->client_name ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label>Point of Contact</label>
        <input type="text" name="point_of_contact" value="{{ old('point_of_contact', $clientRequest->point_of_contact ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6 mt-2">
        <label>Point of Contact Number</label>
        <input type="text" name="point_of_contact_number" value="{{ old('point_of_contact_number', $clientRequest->point_of_contact_number ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6 mt-2">
        <label>Role</label>
        <input type="text" name="role" value="{{ old('role', $clientRequest->role ?? '') }}" class="form-control" required>
    </div>
    <div class="col-md-6 mt-2">
        <label>Position Status</label>
        <input type="text" name="position_status" value="{{ old('position_status', $clientRequest->position_status ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6 mt-2">
        <label>Skill Sets / Requirements</label>
        <textarea name="skills_sets" class="form-control">{{ old('skills_sets', $clientRequest->skills_sets ?? '') }}</textarea>
    </div>
    <div class="col-md-6 mt-2">
        <label>Experience</label>
        <input type="text" name="experience" value="{{ old('experience', $clientRequest->experience ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6 mt-2">
        <label>Location</label>
        <input type="text" name="location" value="{{ old('location', $clientRequest->location ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6 mt-2">
        <label>Panel Availability</label>
        <input type="text" name="panel_availability" value="{{ old('panel_availability', $clientRequest->panel_availability ?? '') }}" class="form-control">
    </div>
    <div class="col-md-12 mt-2">
        <label>Remarks</label>
        <textarea name="remarks" class="form-control">{{ old('remarks', $clientRequest->remarks ?? '') }}</textarea>
    </div>
</div>
