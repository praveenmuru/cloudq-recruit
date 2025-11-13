<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Models\Interview;
use App\Models\ClientRequest;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Date ranges
        $today = Carbon::today();
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();

        // Stats
        $totalCandidates = Candidate::count();
        $totalInterviews = Interview::count();
        $totalClientRequests = ClientRequest::count();

        // Date-based data
        $todayInterviews = Interview::whereDate('created_at', $today)->count();
        $weeklyInterviews = Interview::whereBetween('created_at', [$weekStart, $weekEnd])->count();
        $monthlyInterviews = Interview::whereBetween('created_at', [$monthStart, $monthEnd])->count();

        // Joined candidates
        $joinedToday = Candidate::whereDate('created_at', $today)->count();
        $joinedThisMonth = Candidate::whereBetween('created_at', [$monthStart, $monthEnd])->count();

        // Chart Data (interviews over the last 7 days)
        $chartData = Interview::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->get();

        return view('dashboard.index', compact(
            'totalCandidates',
            'totalInterviews',
            'totalClientRequests',
            'todayInterviews',
            'weeklyInterviews',
            'monthlyInterviews',
            'joinedToday',
            'joinedThisMonth',
            'chartData'
        ));
    }
}
