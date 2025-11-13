@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard Overview</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-3">
        <x-adminlte-small-box title="{{ $totalCandidates }}" text="Total Candidates" icon="fas fa-users" theme="primary"/>
    </div>
    <div class="col-md-3">
        <x-adminlte-small-box title="{{ $totalInterviews }}" text="Total Interviews" icon="fas fa-calendar-check" theme="info"/>
    </div>
    <div class="col-md-3">
        <x-adminlte-small-box title="{{ $totalClientRequests }}" text="Client Requests" icon="fas fa-user-tie" theme="success"/>
    </div>
    <div class="col-md-3">
        <x-adminlte-small-box title="{{ $joinedThisMonth }}" text="Joined This Month" icon="fas fa-briefcase" theme="warning"/>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <x-adminlte-card title="Interview Trends (Last 7 Days)" theme="lightblue" icon="fas fa-chart-line">
            <canvas id="interviewChart"></canvas>
        </x-adminlte-card>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('interviewChart').getContext('2d');
    const interviewChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData->pluck('date')) !!},
            datasets: [{
                label: 'Interviews',
                data: {!! json_encode($chartData->pluck('count')) !!},
                borderWidth: 2,
                borderColor: '#007bff',
                fill: false,
                tension: 0.3
            }]
        }
    });
</script>
@stop
