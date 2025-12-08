<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Candidate;
use App\Models\Interview;
use App\Models\CvStatus;       // adjust if your models are named differently
use App\Models\InterviewStatus;
use App\Models\Offer;

class DashboardController extends Controller
{
    public function index()
    {
        // Preload small sets for blade (so page shows fast while charts load async)
        $upcomingInterviews = Interview::query()
            ->with('candidate')
            ->whereBetween('interview_date', [now()->startOfDay(), now()->addDays(7)->endOfDay()])
            ->orderBy('interview_date')
            ->limit(10)
            ->get();

        // top-level summary (quick display)
        $summary = $this->computeOverviewSummary();

        return view('dashboard.index', compact('upcomingInterviews', 'summary'));
    }

    private function computeOverviewSummary(): array
    {
        $totalCandidates = Candidate::count();

        $interviewsNext7Days = Interview::whereBetween('interview_date', [now()->startOfDay(), now()->addDays(7)->endOfDay()])
            ->count();

        // $offersThisMonth = Offer::whereYear('created_at', now()->year)
        //     ->whereMonth('created_at', now()->month)
        //     ->count();

        $offersThisMonth = 10;

        // CVs pending review = candidates where cv_status is null or specific 'pending' status
        // $pendingCvCount = Candidate::whereNull('cv_status_id')
        //     ->orWhereHas('cvStatus', function($q){
        //         $q->where('code', 'pending')->orWhere('name', 'Pending');
        //     })
        //     ->count();

        $pendingCvCount = 5;

        return [
            'totalCandidates' => $totalCandidates,
            'interviewsNext7Days' => $interviewsNext7Days,
            'offersThisMonth' => $offersThisMonth,
            'pendingCvCount' => $pendingCvCount,
        ];
    }

    // JSON endpoint for KPI cards (optional, we already computed for blade, but useful for refresh)
    public function overviewJson()
    {
        return response()->json($this->computeOverviewSummary());
    }

    // Hiring funnel counts by stage
    public function hiringFunnelJson()
    {
        // If you store stage in candidate.stage or a relation, adapt accordingly.
        $stages = [
            'sourced' => Candidate::where('stage', 'sourced')->count(),
            'shortlisted' => Candidate::where('stage', 'shortlisted')->count(),
            'interview_scheduled' => Candidate::where('stage', 'interview_scheduled')->count(),
            'interview_completed' => Candidate::where('stage', 'interview_completed')->count(),
            'selected' => Candidate::where('stage', 'selected')->count(),
            'offered' => Candidate::where('stage', 'offered')->count(),
            'joined' => Candidate::where('stage', 'joined')->count(),
        ];

        return response()->json($stages);
    }

    // Candidates trend - last 90 days (daily counts)
    public function candidatesTrendJson(Request $request)
    {
        $days = 90;
        $start = now()->subDays($days - 1)->startOfDay();
        $end = now()->endOfDay();

        // Eloquent / raw approach for daily counts:
        $rows = DB::table('candidates')
            ->select(DB::raw('DATE(date_of_joining) as day'), DB::raw('COUNT(*) as count'))
            ->whereBetween('date_of_joining', [$start, $end])
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy('day')
            ->toArray();

        // build full date series (to avoid missing days)
        $labels = [];
        $data = [];
        for ($i = 0; $i < $days; $i++) {
            $d = $start->copy()->addDays($i)->format('Y-m-d');
            $labels[] = $d;
            $data[] = isset($rows[$d]) ? (int)$rows[$d]->count : 0;
        }

        return response()->json(['labels' => $labels, 'data' => $data]);
    }

    // Interviews by day - last 90 days
    public function interviewsByDayJson()
    {
        $days = 90;
        $start = now()->subDays($days - 1)->startOfDay();
        $end = now()->endOfDay();

        $rows = DB::table('interviews')
            ->select(DB::raw('DATE(interview_date) as day'), DB::raw('COUNT(*) as count'))
            ->whereBetween('interview_date', [$start, $end])
            ->groupBy('day')
            ->orderBy('day')
            ->get()
            ->keyBy('day')
            ->toArray();

        $labels = [];
        $data = [];
        for ($i = 0; $i < $days; $i++) {
            $d = $start->copy()->addDays($i)->format('Y-m-d');
            $labels[] = $d;
            $data[] = isset($rows[$d]) ? (int)$rows[$d]->count : 0;
        }

        return response()->json(['labels' => $labels, 'data' => $data]);
    }
}
