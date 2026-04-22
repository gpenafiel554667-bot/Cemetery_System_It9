@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-800">Lot Details</h1>
    <div class="flex gap-2">
        <a href="{{ route('admin.lots.edit', $lot) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">Edit</a>
        <a href="{{ route('admin.lots.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300">Back</a>
    </div>
</div>

<div class="bg-white rounded-xl shadow p-6 max-w-2xl">
    <div class="grid grid-cols-2 gap-4">
        <div>
            <p class="text-gray-500 text-sm">Lot Number</p>
            <p class="font-semibold text-gray-800">{{ $lot->lot_number }}</p>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Section</p>
            <p class="font-semibold text-gray-800">{{ $lot->section }}</p>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Row</p>
            <p class="font-semibold text-gray-800">{{ $lot->row }}</p>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Type</p>
            <p class="font-semibold text-gray-800 capitalize">{{ $lot->type }}</p>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Status</p>
            @if($lot->status === 'available')
                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">Available</span>
            @elseif($lot->status === 'occupied')
                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">Occupied</span>
            @else
                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">Reserved</span>
            @endif
        </div>
        <div>
            <p class="text-gray-500 text-sm">Price</p>
            <p class="font-semibold text-gray-800">₱{{ number_format($lot->price, 2) }}</p>
        </div>
        <div class="col-span-2">
            <p class="text-gray-500 text-sm">Description</p>
            <p class="font-semibold text-gray-800">{{ $lot->description ?? 'N/A' }}</p>
        </div>
    </div>
</div>
@endsection