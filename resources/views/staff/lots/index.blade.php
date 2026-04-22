@extends('layouts.staff')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Lots & Plots</h1>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left px-6 py-4 text-gray-600">Lot Number</th>
                <th class="text-left px-6 py-4 text-gray-600">Section</th>
                <th class="text-left px-6 py-4 text-gray-600">Row</th>
                <th class="text-left px-6 py-4 text-gray-600">Type</th>
                <th class="text-left px-6 py-4 text-gray-600">Status</th>
                <th class="text-left px-6 py-4 text-gray-600">Price</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lots as $lot)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-6 py-4 font-medium">{{ $lot->lot_number }}</td>
                <td class="px-6 py-4">{{ $lot->section }}</td>
                <td class="px-6 py-4">{{ $lot->row }}</td>
                <td class="px-6 py-4 capitalize">{{ $lot->type }}</td>
                <td class="px-6 py-4">
                    <span class="text-xs px-2 py-1 rounded-full
                        {{ $lot->status === 'available' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $lot->status === 'occupied' ? 'bg-red-100 text-red-700' : '' }}
                        {{ $lot->status === 'reserved' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                        {{ ucfirst($lot->status) }}
                    </span>
                </td>
                <td class="px-6 py-4">₱{{ number_format($lot->price, 2) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-400">No lots found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $lots->links() }}</div>
</div>
@endsection