@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Payment Records</h1>
        <p class="text-gray-500 text-sm mt-1">Manage all burial and maintenance payment records.</p>
    </div>
    <a href="{{ route('admin.payments.create') }}" class="bg-gray-900 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">Add Payment</a>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Total Collections</p>
        <h2 class="text-2xl font-bold text-gray-900 mt-1">PHP {{ number_format(\App\Models\Payment::sum('amount'), 2) }}</h2>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Paid</p>
        <h2 class="text-2xl font-bold text-green-600 mt-1">PHP {{ number_format(\App\Models\Payment::where('status','paid')->sum('amount'), 2) }}</h2>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Unpaid</p>
        <h2 class="text-2xl font-bold text-red-600 mt-1">PHP {{ number_format(\App\Models\Payment::where('status','unpaid')->sum('amount'), 2) }}</h2>
    </div>
</div>

<!-- Table -->
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide">All Payments</h2>
        <span class="text-xs text-gray-400">{{ $payments->total() }} total</span>
    </div>
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Deceased</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Type</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Amount</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Date</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($payments as $payment)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $payment->burial->deceased->first_name }} {{ $payment->burial->deceased->last_name }}</td>
                <td class="px-6 py-4 text-sm text-gray-600 capitalize">{{ str_replace('_', ' ', $payment->type) }}</td>
                <td class="px-6 py-4 text-sm font-semibold text-gray-900">PHP {{ number_format($payment->amount, 2) }}</td>
                <td class="px-6 py-4">
                    @if($payment->status === 'paid')
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Paid</span>
                    @elseif($payment->status === 'unpaid')
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">Unpaid</span>
                    @else
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Partial</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') : 'N/A' }}</td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.payments.show', $payment) }}" class="bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-gray-200 transition">View</a>
                        <a href="{{ route('admin.payments.edit', $payment) }}" class="bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-blue-100 transition">Edit</a>
                        <form method="POST" action="{{ route('admin.payments.destroy', $payment) }}" onsubmit="return confirm('Are you sure?')">
                            @csrf @method('DELETE')
                            <button class="bg-red-50 text-red-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-red-100 transition">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">No payment records found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-gray-100">{{ $payments->links() }}</div>
</div>
@endsection