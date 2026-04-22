@extends('layouts.staff')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Staff Dashboard</h1>
    <p class="text-gray-500 text-sm mt-1">Welcome back, {{ auth()->user()->name }}.</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Total Deceased</p>
        <h2 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalDeceased }}</h2>
        <p class="text-gray-400 text-xs mt-2">Deceased records</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Total Burials</p>
        <h2 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalBurials }}</h2>
        <p class="text-gray-400 text-xs mt-2">Burial records</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Pending Inquiries</p>
        <h2 class="text-3xl font-bold text-gray-900 mt-2">{{ $pendingInquiries }}</h2>
        <p class="text-gray-400 text-xs mt-2">Awaiting response</p>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

    <!-- Burials per Month -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-1">Burials per Month</h2>
        <p class="text-gray-400 text-xs mb-4">{{ date('Y') }} burial records overview</p>
        <canvas id="burialsChart" height="140"></canvas>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-4">Quick Actions</h2>
        <div class="space-y-3">
            <a href="{{ route('staff.deceased.create') }}" class="flex items-center gap-4 p-3 rounded-lg border border-gray-100 hover:border-gray-300 hover:bg-gray-50 transition">
                <div class="w-9 h-9 bg-gray-900 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">Add Deceased Record</p>
                    <p class="text-xs text-gray-500">Add a new deceased record</p>
                </div>
            </a>
            <a href="{{ route('staff.burials.create') }}" class="flex items-center gap-4 p-3 rounded-lg border border-gray-100 hover:border-gray-300 hover:bg-gray-50 transition">
                <div class="w-9 h-9 bg-gray-900 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">Add Burial Record</p>
                    <p class="text-xs text-gray-500">Record a new burial</p>
                </div>
            </a>
            <a href="{{ route('staff.families.create') }}" class="flex items-center gap-4 p-3 rounded-lg border border-gray-100 hover:border-gray-300 hover:bg-gray-50 transition">
                <div class="w-9 h-9 bg-gray-900 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">Add Family Record</p>
                    <p class="text-xs text-gray-500">Add next of kin information</p>
                </div>
            </a>
            <a href="{{ route('staff.payments.create') }}" class="flex items-center gap-4 p-3 rounded-lg border border-gray-100 hover:border-gray-300 hover:bg-gray-50 transition">
                <div class="w-9 h-9 bg-gray-900 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">Record Payment</p>
                    <p class="text-xs text-gray-500">Add a new payment record</p>
                </div>
            </a>
            <a href="{{ route('staff.inquiries.index') }}" class="flex items-center gap-4 p-3 rounded-lg border border-gray-100 hover:border-gray-300 hover:bg-gray-50 transition">
                <div class="w-9 h-9 bg-gray-900 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-gray-900">View Inquiries</p>
                    <p class="text-xs text-gray-500">Check and respond to inquiries</p>
                </div>
            </a>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const burialData = @json($burialData->values());

    new Chart(document.getElementById('burialsChart'), {
        type: 'bar',
        data: {
            labels: months,
            datasets: [{
                label: 'Burials',
                data: burialData,
                backgroundColor: 'rgba(17, 24, 39, 0.8)',
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, color: '#9ca3af', font: { size: 11 } },
                    grid: { color: '#f3f4f6' }
                },
                x: {
                    ticks: { color: '#9ca3af', font: { size: 11 } },
                    grid: { display: false }
                }
            }
        }
    });
</script>
@endsection