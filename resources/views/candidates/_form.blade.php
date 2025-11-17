@php
    $candidate = $candidate ?? null;
    $keywords = old('keywords', $candidate ? $candidate->keywords : []);
@endphp

<form method="POST" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @if($method ?? null)
        @method($method)
    @endif

    <div class="row">
        <div class="col-md-6">
            <x-adminlte-input name="name" label="Name" value="{{ old('name', $candidate->name ?? '') }}" />
            <x-adminlte-input name="title" label="Title" value="{{ old('title', $candidate->title ?? '') }}" />
            <x-adminlte-input name="client" label="Client" value="{{ old('client', $candidate->client ?? '') }}" />
            <div class="form-group">
                <label for="skills">Keywords</label>
                <select name="skills[]" id="skills" class="form-control select2" multiple>
                    @foreach($skills as $id => $name)
                        <option value="{{ $id }}" 
                            {{ (collect(old('skills', $candidate?->skills->pluck('id') ?? []))->contains($id)) ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <x-adminlte-input name="phone" label="Phone" value="{{ old('phone', $candidate->phone ?? '') }}" />
            <x-adminlte-input name="alternate_phone" label="Alternate Phone" value="{{ old('alternate_phone', $candidate->alternate_phone ?? '') }}" />
            <x-adminlte-input name="email" label="Email" value="{{ old('email', $candidate->email ?? '') }}" />
        </div>

        <div class="col-md-6">
            <x-adminlte-input name="current_company" label="Current Company" value="{{ old('current_company', $candidate->current_company ?? '') }}" />
            <x-adminlte-input name="current_role" label="Current Role" value="{{ old('current_role', $candidate->current_role ?? '') }}" />

            <div class="row">
                <div class="col">
                    <x-adminlte-input name="total_exp" label="Total Exp (yrs)" value="{{ old('total_exp', $candidate->total_exp ?? '') }}" />
                </div>
                <div class="col">
                    <x-adminlte-input name="relevant_exp" label="Relevant Exp (yrs)" value="{{ old('relevant_exp', $candidate->relevant_exp ?? '') }}" />
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <x-adminlte-input name="ctc" label="CTC (LPA)" value="{{ old('ctc', $candidate->ctc ?? '') }}" />
                </div>
                <div class="col">
                    <x-adminlte-input name="ectc" label="Expected CTC (LPA)" value="{{ old('ectc', $candidate->ectc ?? '') }}" />
                </div>
            </div>

            <x-adminlte-input name="notice_period" label="Notice Period" value="{{ old('notice_period', $candidate->notice_period ?? '') }}" />
            <x-adminlte-input name="earliest_availability" label="Earliest Availability" value="{{ old('earliest_availability', $candidate->earliest_availability ?? '') }}" />
<div class="form-group">
    <label for="location_id">Current Location</label>
    <select name="location_id" id="location_id" class="form-control select2">
        <option value="">-- Select Location --</option>
        @foreach($locations as $id => $name)
            <option value="{{ $id }}" {{ old('location_id', $candidate->location_id ?? '') == $id ? 'selected' : '' }}>{{ $name }}</option>
        @endforeach
    </select>
</div>            
<div class="form-group">
    <label for="preferred_locations">Preferred Locations</label>
    <select name="preferred_locations[]" id="preferred_locations" class="form-control select2" multiple>
        @foreach($locations as $id => $name)

               <option value="{{ $id }}" 
                            {{ (collect(old('preferred_locations', $candidate?->preferredLocations->pluck('id') ?? []))->contains($id)) ? 'selected' : '' }}>
                            {{ $name }}
                        </option>


        @endforeach
    </select>
</div>
            <div class="form-group">
                <label for="work_type">Work Type</label>
                <select name="work_type" id="work_type" class="form-control">
                    <option value="Remote" {{ old('work_type', $candidate->work_type ?? '') == 'Remote' ? 'selected' : '' }}>Remote</option>
                    <option value="Inoffice" {{ old('work_type', $candidate->work_type ?? '') == 'Inoffice' ? 'selected' : '' }}>Inoffice</option>
                    <option value="Hybrid" {{ old('work_type', $candidate->work_type ?? '') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                </select>
            </div>

            <x-adminlte-textarea name="reason_for_job_change" label="Reason for job change">{{ old('reason_for_job_change', $candidate->reason_for_job_change ?? '') }}</x-adminlte-textarea>
            <x-adminlte-textarea name="remarks" label="Remarks">{{ old('remarks', $candidate->remarks ?? '') }}</x-adminlte-textarea>

            <x-adminlte-input name="resume_link" label="Resume Link (Google Drive)" value="{{ old('resume_link', $candidate->resume_link ?? '') }}" />
            <div class="mt-3">
                <button class="btn btn-primary" type="submit">Save</button>
                <a href="{{ route('candidates.index') }}" class="btn btn-default">Cancel</a>
            </div>
        </div>
    </div>
</form>

@push('js')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(function () {
        $('.select2').select2({
            placeholder: 'Select option',
            width: '100%'
        });
    });
</script>
@endpush
