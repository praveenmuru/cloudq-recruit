<?php
namespace App\Http\Controllers;

use App\Models\Interview;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
public function index(Request $request)
{
    $query = Interview::query();

    // Filters
    if ($request->filled('client_name')) {
        $query->where('client_name', 'like', '%' . $request->client_name . '%');
    }

    if ($request->filled('role')) {
        $query->where('role', 'like', '%' . $request->role . '%');
    }

    if ($request->filled('cv_status')) {
        $query->where('cv_status', $request->cv_status);
    }

    if ($request->filled('interview_status')) {
        $query->where('interview_status', $request->interview_status);
    }

    if ($request->filled('offer_status')) {
        $query->where('offer_status', $request->offer_status);
    }

    if ($request->filled('from_date') && $request->filled('to_date')) {
        $query->whereBetween('interview_date', [$request->from_date, $request->to_date]);
    }

    $interviews = $query->latest()->paginate(10)->appends($request->all());

    return view('interviews.index', compact('interviews'));
}


    public function create()
    {
        return view('interviews.create');
    }

    public function store(Request $request)
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

        Interview::create($validated);
        return redirect()->route('interviews.index')->with('success', 'Interview added successfully!');
    }

    public function edit(Interview $interview)
    {
        return view('interviews.edit', compact('interview'));
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
