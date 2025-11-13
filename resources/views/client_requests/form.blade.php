<div class="row">
<div class="col-md-6">
    <label>Client Name</label>
    <select name="client_name" id="client_name" class="form-control select2" required>
        <option value="">Select or type to add</option>
        @foreach(\App\Models\Client::orderBy('name')->get() as $client)
            <option value="{{ $client->name }}"
                {{ old('client_name', $clientRequest->client->name ?? '') == $client->name ? 'selected' : '' }}>
                {{ $client->name }}
            </option>
        @endforeach
    </select>
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
    <select name="role" id="role" class="form-control select2" required>
        @foreach(\App\Models\Role::all() as $role)
            <option value="{{ $role->name }}"
                {{ old('role', $clientRequest->role->name ?? '') == $role->name ? 'selected' : '' }}>
                {{ $role->name }}
            </option>
        @endforeach
    </select>
</div>
    <div class="col-md-6 mt-2">
        <label>Position Status</label>
        <input type="text" name="position_status" value="{{ old('position_status', $clientRequest->position_status ?? '') }}" class="form-control">
    </div>
  <div class="col-md-6 mt-2">
    <label>Skill Sets / Requirements</label>
    <select name="skills[]" id="skills" class="form-control select2" multiple>
        @foreach(\App\Models\Skill::all() as $skill)
            <option value="{{ $skill->name }}"
                @if(isset($clientRequest))
                    {{ $clientRequest->skills->pluck('name')->contains($skill->name) ? 'selected' : '' }}
                @endif
            >
                {{ $skill->name }}
            </option>
        @endforeach
    </select>
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
