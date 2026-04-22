@extends('layouts.admin')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Reports & Overview</h1>
        <p class="text-gray-500 text-sm mt-1">Complete summary of the cemetery management system.</p>
    </div>
    <a href="{{ route('admin.reports.pdf') }}" class="bg-gray-900 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">
        Export PDF
    </a>
</div>

<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
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
        <p class="text-gray-500 text-xs uppercase tracking-wide">Total Inquiries</p>
        <h2 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalInquiries }}</h2>
        <p class="text-gray-400 text-xs mt-2">All inquiries</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Total Users</p>
        <h2 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalUsers }}</h2>
        <p class="text-gray-400 text-xs mt-2">Admin & Staff accounts</p>
    </div>
</div>

<!-- Lots Summary -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Available Lots</p>
        <h2 class="text-3xl font-bold text-green-600 mt-2">{{ $availableLots }}</h2>
        <p class="text-gray-400 text-xs mt-2">out of {{ $totalLots }} total lots</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Occupied Lots</p>
        <h2 class="text-3xl font-bold text-red-600 mt-2">{{ $occupiedLots }}</h2>
        <p class="text-gray-400 text-xs mt-2">out of {{ $totalLots }} total lots</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Reserved Lots</p>
        <h2 class="text-3xl font-bold text-yellow-600 mt-2">{{ $reservedLots }}</h2>
        <p class="text-gray-400 text-xs mt-2">out of {{ $totalLots }} total lots</p>
    </div>
</div>

<!-- Payments Summary -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Total Collections</p>
        <h2 class="text-3xl font-bold text-gray-900 mt-2">PHP {{ number_format($totalPayments, 2) }}</h2>
        <p class="text-gray-400 text-xs mt-2">All payments combined</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Paid</p>
        <h2 class="text-3xl font-bold text-green-600 mt-2">PHP {{ number_format($paidPayments, 2) }}</h2>
        <p class="text-gray-400 text-xs mt-2">Fully settled payments</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Unpaid</p>
        <h2 class="text-3xl font-bold text-red-600 mt-2">PHP {{ number_format($unpaidPayments, 2) }}</h2>
        <p class="text-gray-400 text-xs mt-2">Outstanding balance</p>
    </div>
</div>

<!-- Recent Deceased -->
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide">Recent Deceased Records</h2>
    </div>
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Name</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Date of Birth</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Date of Death</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Cause of Death</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($recentDeceased as $record)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $record->first_name }} {{ $record->last_name }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($record->date_of_birth)->format('F d, Y') }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($record->date_of_death)->format('F d, Y') }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $record->cause_of_death ?? 'N/A' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-400">No records found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Recent Payments -->
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200">
        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide">Recent Payments</h2>
    </div>
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Deceased</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Type</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Amount</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Date</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($recentPayments as $payment)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $payment->burial->deceased->first_name }} {{ $payment->burial->deceased->last_name }}</td>
                <td class="px-6 py-4 text-sm text-gray-600 capitalize">{{ str_replace('_', ' ', $payment->type) }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">PHP {{ number_format($payment->amount, 2) }}</td>
                <td class="px-6 py-4">
                    @if($payment->status === 'paid')
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Paid</span>
                    @elseif($payment->status === 'unpaid')
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">Unpaid</span>
                    @else
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Partial</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('F d, Y') : 'N/A' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-400">No payments found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection