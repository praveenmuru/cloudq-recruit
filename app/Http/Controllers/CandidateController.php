<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidateRequest;
use App\Models\Candidate;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // adjust as needed
    }

    public function index(Request $request)
    {
        $query = Candidate::query();

        // Filters (client, name, keyword, location, work_type, date range)
        if ($request->filled('client')) {
            $query->where('client', 'like', '%'.$request->client.'%');
        }
        if ($request->filled('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->whereJsonContains('keywords', $keyword);
        }
        if ($request->filled('location')) {
            $query->where('location', 'like', '%'.$request->location.'%');
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

        return view('candidates.index', compact('candidates'));
    }

    public function create()
    {
        return view('candidates.create');
    }

    public function store(CandidateRequest $request)
    {
        $data = $request->validated();

        // Ensure keywords are array
        $data['keywords'] = $data['keywords'] ?? [];

        Candidate::create($data);

        return redirect()->route('candidates.index')->with('success', 'Candidate created.');
    }

    public function show(Candidate $candidate)
    {
        return view('candidates.show', compact('candidate'));
    }

    public function edit(Candidate $candidate)
    {
        return view('candidates.edit', compact('candidate'));
    }

    public function update(CandidateRequest $request, Candidate $candidate)
    {
        $data = $request->validated();
        $data['keywords'] = $data['keywords'] ?? [];
        $candidate->update($data);

        return redirect()->route('candidates.index')->with('success', 'Candidate updated.');
    }

    public function destroy(Candidate $candidate)
    {
        $candidate->delete();
        return redirect()->route('candidates.index')->with('success', 'Candidate deleted.');
    }
}
