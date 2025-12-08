@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Recruitment Dashboard</h1>
@stop

@section('content')
<div class="row">
    <!-- KPI cards -->
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3 id="kpi-total-candidates">{{ $summary['totalCandidates'] }}</h3>
                <p>Total Candidates</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
            <a href="{{ route('candidates.index') }}" class="small-box-footer">Manage candidates <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3 id="kpi-interviews-next-7">{{ $summary['interviewsNext7Days'] }}</h3>
                <p>Interviews (next 7 days)</p>
            </div>
            <div class="icon"><i class="fas fa-calendar-alt"></i></div>
            <a href="{{ route('interviews.index') }}" class="small-box-footer">View schedule <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3 id="kpi-offers-month">{{ $summary['offersThisMonth'] }}</h3>
                <p>Offers this month</p>
            </div>
            <div class="icon"><i class="fas fa-handshake"></i></div>
            {{-- <a href="{{ route('offers.index') }}" class="small-box-footer">Manage offers <i class="fas fa-arrow-circle-right"></i></a> --}}
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3 id="kpi-pending-cv">{{ $summary['pendingCvCount'] }}</h3>
                <p>CVs pending review</p>
            </div>
            <div class="icon"><i class="fas fa-file-alt"></i></div>
            <a href="{{ route('candidates.index') }}" class="small-box-footer">Review CVs <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<!-- Row: Funnel + Calendar/Pie -->
<div class="row">
    <div class="col-lg-7">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Hiring Funnel</h3>
            </div>
            <div class="card-body">
                <canvas id="hiringFunnelChart" height="140"></canvas>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Interviews (Next 7 days)</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr><th>Candidate</th><th>Date</th><th>Time</th><th>Interviewer</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                    @forelse($upcomingInterviews as $iv)
                        <tr>
                            <td>{{ $iv->candidate->name ?? '—' }}</td>
                            <td>{{ \Carbon\Carbon::parse($iv->interview_date)->format('Y-m-d') }}</td>
                            <td>{{ \Carbon\Carbon::parse($iv->interview_date)->format('H:i') }}</td>
                            <td>{{ $iv->interviewer->name ?? ($iv->interviewer_name ?? '—') }}</td>
                            <td>{{ $iv->status ?? ($iv->interviewStatus->name ?? '—') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5">No interviews scheduled.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Status Distribution</h3></div>
            <div class="card-body">
                <canvas id="cvStatusChart" style="max-height:220px"></canvas>
                <hr />
                <canvas id="interviewStatusChart" style="max-height:220px"></canvas>
                <hr />
                <canvas id="offerStatusChart" style="max-height:220px"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Row: Trends -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Candidates — Last 90 days</h3></div>
            <div class="card-body">
                <canvas id="candidatesTrendChart" height="120"></canvas>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<!-- Add any required CSS here -->
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Helper to request JSON
    function fetchJson(url){
        return fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }})
            .then(r => r.json());
    }

    // Hiring Funnel
    fetchJson('{{ route('dashboard.stats.funnel') }}').then(resp => {
        const labels = Object.keys(resp).map(k => k.replace(/_/g, ' ').toUpperCase());
        const data = Object.values(resp);

        new Chart(document.getElementById('hiringFunnelChart'), {
            type: 'bar',
            data: { labels, datasets: [{ label: 'Candidates', data }] },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true } }
            }
        });
    });

    // Candidates trend (last 90 days)
    fetchJson('{{ route('dashboard.stats.candidates_trend') }}').then(resp => {
        new Chart(document.getElementById('candidatesTrendChart'), {
            type: 'line',
            data: {
                labels: resp.labels.map(l => l.substr(5)), // show MM-DD to save space
                datasets: [{
                    label: 'New candidates',
                    data: resp.data,
                    fill: true,
                    tension: 0.2,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true } }
            }
        });
    });

    // Status pie charts - build using server-side small queries (make endpoints if needed)
    // For simplicity we'll compute client-side using small endpoints or inline fetches.
    // CV Status
    fetchJson('/api/dashboard/statuses/cv').then(resp => {
        if (!resp) return;
        new Chart(document.getElementById('cvStatusChart'), {
            type: 'doughnut',
            data: {
                labels: resp.labels,
                datasets: [{ data: resp.data }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    }).catch(()=>{ /* optionally implement fallback */ });

    // Interview Status
    fetchJson('/api/dashboard/statuses/interview').then(resp => {
        if (!resp) return;
        new Chart(document.getElementById('interviewStatusChart'), {
            type: 'doughnut',
            data: { labels: resp.labels, datasets: [{ data: resp.data }] },
            options: { responsive: true, maintainAspectRatio: false }
        });
    }).catch(()=>{});

    // Offer Status
    fetchJson('/api/dashboard/statuses/offer').then(resp => {
        if (!resp) return;
        new Chart(document.getElementById('offerStatusChart'), {
            type: 'doughnut',
            data: { labels: resp.labels, datasets: [{ data: resp.data }] },
            options: { responsive: true, maintainAspectRatio: false }
        });
    }).catch(()=>{});
});
</script>
@stop
