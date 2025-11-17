<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\Skill;
use App\Models\Location;
use App\Http\Requests\CandidateRequest;
use Illuminate\Support\Str;

class CandidateController extends Controller
{
    public function index(Request $request)
    {
        $query = Candidate::with(['skills', 'location', 'preferredLocations']);

        // --- Filters ---
        if ($request->filled('client')) {
            $query->where('client', 'like', '%'.$request->client.'%');
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }

        if ($request->filled('skill_id')) {
            $query->whereHas('skills', fn($q) => $q->where('skill_id', $request->skill_id));
        }

        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        if ($request->filled('preferred_location_id')) {
            $query->whereHas('preferredLocations', fn($q) => $q->where('locations.id', $request->preferred_location_id));
        }

        if ($request->filled('work_type')) {
            $query->where('work_type', $request->work_type);
        }

        if ($request->filled('joined_from')) {
            $query->whereDate('date_of_joining', '>=', $request->joined_from);
        }

        if ($request->filled('joined_to')) {
            $query->whereDate('date_of_joining', '<=', $request->joined_to);
        }

        $candidates = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        $skills = Skill::orderBy('name')->pluck('name', 'id');
        $locations = Location::orderBy('name')->pluck('name', 'id');

        return view('candidates.index', compact('candidates', 'skills', 'locations'));
    }

    public function create()
    {
        $skills = Skill::orderBy('name')->pluck('name', 'id');
        $locations = Location::orderBy('name')->pluck('name', 'id');
        return view('candidates.create', compact('skills', 'locations'));
    }

public function store(CandidateRequest $request)
{
    $data = $request->validated();

    // --- Handle dynamic Skills ---
    $skillsInput = $request->input('skills', []);
    $skillIds = [];
    foreach ($skillsInput as $skill) {
        if (is_numeric($skill)) {
            $skillIds[] = $skill;
        } else {
            // Create new skill if doesn't exist
            $newSkill = Skill::firstOrCreate(['name' => Str::title(trim($skill))]);
            $skillIds[] = $newSkill->id;
        }
    }

    // --- Handle dynamic Locations ---
    $locationId = null;
    if ($request->filled('location_id')) {
        $loc = $request->input('location_id');
        if (is_numeric($loc)) {
            $locationId = $loc;
        } else {
            $newLocation = Location::firstOrCreate(['name' => Str::title(trim($loc))]);
            $locationId = $newLocation->id;
        }
    }

    // --- Handle Preferred Locations ---
    $preferredInput = $request->input('preferred_locations', []);
    $preferredIds = [];
    foreach ($preferredInput as $loc) {
        if (is_numeric($loc)) {
            $preferredIds[] = $loc;
        } else {
            $newLocation = Location::firstOrCreate(['name' => Str::title(trim($loc))]);
            $preferredIds[] = $newLocation->id;
        }
    }

    $data['location_id'] = $locationId;
    $candidate = Candidate::create($data);

    $candidate->skills()->sync($skillIds);
    $candidate->preferredLocations()->sync($preferredIds);

    return redirect()->route('candidates.index')->with('success', 'Candidate created successfully.');
}

public function update(CandidateRequest $request, Candidate $candidate)
{
    $data = $request->validated();

    // --- Handle dynamic Skills ---
    $skillsInput = $request->input('skills', []);
    $skillIds = [];
    foreach ($skillsInput as $skill) {
        if (is_numeric($skill)) {
            $skillIds[] = $skill;
        } else {
            $newSkill = Skill::firstOrCreate(['name' => Str::title(trim($skill))]);
            $skillIds[] = $newSkill->id;
        }
    }

    // --- Handle dynamic Locations ---
    $locationId = null;
    if ($request->filled('location_id')) {
        $loc = $request->input('location_id');
        if (is_numeric($loc)) {
            $locationId = $loc;
        } else {
            $newLocation = Location::firstOrCreate(['name' => Str::title(trim($loc))]);
            $locationId = $newLocation->id;
        }
    }

    // --- Handle Preferred Locations ---
    $preferredInput = $request->input('preferred_locations', []);
    $preferredIds = [];
    foreach ($preferredInput as $loc) {
        if (is_numeric($loc)) {
            $preferredIds[] = $loc;
        } else {
            $newLocation = Location::firstOrCreate(['name' => Str::title(trim($loc))]);
            $preferredIds[] = $newLocation->id;
        }
    }

    $data['location_id'] = $locationId;
    $candidate->update($data);

    $candidate->skills()->sync($skillIds);
    $candidate->preferredLocations()->sync($preferredIds);

    return redirect()->route('candidates.index')->with('success', 'Candidate updated successfully.');
}

    public function edit(Candidate $candidate)
    {
        $skills = Skill::orderBy('name')->pluck('name', 'id');
        $locations = Location::orderBy('name')->pluck('name', 'id');

        $candidate->load(['skills', 'preferredLocations']);

        return view('candidates.edit', compact('candidate', 'skills', 'locations'));
    }


    public function show(Candidate $candidate)
    {
        $candidate->load(['skills', 'location', 'preferredLocations']);
        return view('candidates.show', compact('candidate'));
    }


    public function destroy(Candidate $candidate)
    {
        $candidate->delete();
        return redirect()->route('candidates.index')->with('success', 'Candidate deleted.');
    }
}
