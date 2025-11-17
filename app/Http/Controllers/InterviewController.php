<?php
namespace App\Http\Controllers;

use App\Models\Interview;
use App\Models\Client;
use App\Models\Candidate;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Interview::with(['client', 'candidate']);

        // Filter by client ID
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        // Filter by candidate ID
        if ($request->filled('candidate_id')) {
            $query->where('candidate_id', $request->candidate_id);
        }

        // Role filter (string)
        if ($request->filled('role')) {
            $query->where('role', 'like', '%' . $request->role . '%');
        }

        // CV Status filter
        if ($request->filled('cv_status')) {
            $query->where('cv_status', $request->cv_status);
        }

        // Interview Status
        if ($request->filled('interview_status')) {
            $query->where('interview_status', $request->interview_status);
        }

        // Offer Status
        if ($request->filled('offer_status')) {
            $query->where('offer_status', $request->offer_status);
        }

        // Date range
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('interview_date', [$request->from_date, $request->to_date]);
        }

        // Data + append filters
        $interviews = $query->latest()->paginate(15)->appends($request->all());

        // For filters
        $clients = \App\Models\Client::orderBy('name')->pluck('name', 'id');
        $candidates = \App\Models\Candidate::orderBy('name')->pluck('name', 'id');

        return view('interviews.index', compact('interviews', 'clients', 'candidates'));
    }


    public function create()
    {
        $clients = Client::pluck('name', 'id');   // [id => name]
    $candidates = Candidate::pluck('name', 'id'); // if needed

    return view('interviews.create', compact('clients', 'candidates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'candidate_id' => 'required|exists:candidates,id',
            'role' => 'required|string|max:255',
            'cv_status' => 'required|string',
            'interview_date' => 'nullable|date',
            'interview_time' => 'nullable',
            'client_round' => 'nullable|string|max:255',
            'interview_status' => 'required|string',
            'offer_status' => 'required|string',
            'offered_salary' => 'nullable|numeric',
            'joining_date' => 'nullable|date',
        ]);

        $interview = Interview::create($validated);

        if (!$interview) {
            return back()->with('error', 'Failed to save interview.');
        }

        return redirect()->route('interviews.index')
                        ->with('success', 'Interview added successfully!');
    }

    public function edit(Interview $interview)
    {
        $clients = Client::pluck('name', 'id');   // [id => name]
        $candidates = Candidate::pluck('name', 'id'); // if needed
        return view('interviews.edit', compact('interview','clients', 'candidates'));
    }

    public function update(Request $request, Interview $interview)
    {
        
        $validated = $request->validate([
            'client_name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'candidate_name' => 'required|string|max:255',
            'cv_status' => 'required|string',
            'interview_date' => 'nullable|date',
            'interview_time' => 'nullable',
            'client_round' => 'nullable|string|max:255',
            'interview_status' => 'required|string',
            'offer_status' => 'required|string',
            'offered_salary' => 'nullable|numeric',
            'joining_date' => 'nullable|date',
        ]);

        $interview->update($validated);
        return redirect()->route('interviews.index')->with('success', 'Interview updated successfully!');
    }

    public function destroy(Interview $interview)
    {
        $interview->delete();
        return redirect()->route('interviews.index')->with('success', 'Interview deleted successfully!');
    }
}
