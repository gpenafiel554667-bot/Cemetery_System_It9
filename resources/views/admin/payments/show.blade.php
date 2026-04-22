@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-800">Payment Record</h1>
    <div class="flex gap-2">
        <a href="{{ route('admin.payments.edit', $payment) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">Edit</a>
        <a href="{{ route('admin.payments.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300">Back</a>
    </div>
</div>

<div class="bg-white rounded-xl shadow p-6 max-w-2xl">
    <div class="grid grid-cols-2 gap-4">
        <div>
            <p class="text-gray-500 text-sm">Deceased</p>
            <p class="font-semibold text-gray-800">
                {{ $payment->burial->deceased->first_name ?? 'N/A' }} {{ $payment->burial->deceased->last_name ?? '' }}
            </p>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Burial Date</p>
            <p class="font-semibold text-gray-800">{{ $payment->burial->burial_date ?? 'N/A' }}</p>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Type</p>
            <p class="font-semibold text-gray-800 capitalize">{{ str_replace('_', ' ', $payment->type) }}</p>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Amount</p>
            <p class="font-semibold text-gray-800">₱{{ number_format($payment->amount, 2) }}</p>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Status</p>
            @if($payment->status === 'paid')
                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-semibold">Paid</span>
            @elseif($payment->status === 'partial')
                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-semibold">Partial</span>
            @else
                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-xs font-semibold">Unpaid</span>
            @endif
        </div>
        <div>
            <p class="text-gray-500 text-sm">Payment Date</p>
            <p class="font-semibold text-gray-800">{{ $payment->payment_date ?? 'N/A' }}</p>
        </div>
        <div class="col-span-2">
            <p class="text-gray-500 text-sm">Notes</p>
            <p class="font-semibold text-gray-800">{{ $payment->notes ?? 'N/A' }}</p>
        </div>
    </div>
</div>
@endsection