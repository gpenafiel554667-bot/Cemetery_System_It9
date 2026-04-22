@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-800">Burial Record</h1>
    <div class="flex gap-2">
        <a href="{{ route('admin.burials.edit', $burial) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">Edit</a>
        <a href="{{ route('admin.burials.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300">Back</a>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 max-w-2xl">

    {{-- Burial Details --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-bold text-gray-700 mb-4">Burial Details</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-500 text-sm">Deceased</p>
                <p class="font-semibold text-gray-800">{{ $burial->deceased->first_name }} {{ $burial->deceased->last_name }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Burial Date</p>
                <p class="font-semibold text-gray-800">{{ $burial->burial_date }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Burial Type</p>
                <p class="font-semibold text-gray-800 capitalize">{{ $burial->burial_type }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Lot</p>
                <p class="font-semibold text-gray-800">Section {{ $burial->lot->section }} — Row {{ $burial->lot->row }} — Lot {{ $burial->lot->lot_number }}</p>
            </div>
            <div class="col-span-2">
                <p class="text-gray-500 text-sm">Notes</p>
                <p class="font-semibold text-gray-800">{{ $burial->notes ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    {{-- Payment Records --}}
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-bold text-gray-700">Payment Records</h2>
            <a href="{{ route('admin.payments.create') }}" class="bg-gray-900 text-white px-3 py-1 rounded-lg text-sm hover:bg-gray-700 transition">➕ Add Payment</a>
        </div>
        @forelse($burial->payments as $payment)
        <div class="border rounded-lg px-4 py-3 mb-2 flex justify-between items-center">
            <div>
                <p class="font-semibold text-gray-800 capitalize">{{ str_replace('_', ' ', $payment->type) }}</p>
                <p class="text-gray-500 text-sm">{{ $payment->payment_date ?? 'No date' }}</p>
            </div>
            <div class="text-right">
                <p class="font-bold text-gray-800">₱{{ number_format($payment->amount, 2) }}</p>
                <span class="text-xs px-2 py-1 rounded-full
                    {{ $payment->status === 'paid' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $payment->status === 'unpaid' ? 'bg-red-100 text-red-700' : '' }}
                    {{ $payment->status === 'partial' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                    {{ ucfirst($payment->status) }}
                </span>
            </div>
        </div>
        @empty
        <p class="text-gray-400 text-sm">No payment records yet.</p>
        @endforelse
    </div>

</div>
@endsection