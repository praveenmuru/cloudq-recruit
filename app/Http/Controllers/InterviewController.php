<?php
namespace App\Http\Controllers;

use App\Models\Interview;
use Illuminate\Http\Request;

class InterviewController extends Controller
{
    public function index()
    {
        $interviews = Interview::latest()->paginate(10);
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
