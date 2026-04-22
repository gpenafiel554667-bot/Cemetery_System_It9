@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Burial Records</h1>
        <p class="text-gray-500 text-sm mt-1">Manage all burial records in the system.</p>
    </div>
    <a href="{{ route('admin.burials.create') }}" class="bg-gray-900 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">Add Burial</a>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Total Burials</p>
        <h2 class="text-2xl font-bold text-gray-900 mt-1">{{ $burials->total() }}</h2>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-gray-500 text-xs uppercase tracking-wide">This Month</p>
        <h2 class="text-2xl font-bold text-gray-900 mt-1">{{ \App\Models\Burial::whereMonth('burial_date', now()->month)->whereYear('burial_date', now()->year)->count() }}</h2>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-gray-500 text-xs uppercase tracking-wide">This Year</p>
        <h2 class="text-2xl font-bold text-gray-900 mt-1">{{ \App\Models\Burial::whereYear('burial_date', now()->year)->count() }}</h2>
    </div>
</div>

<!-- Table -->
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide">All Burials</h2>
        <span class="text-xs text-gray-400">{{ $burials->total() }} total</span>
    </div>
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Deceased</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Lot</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Burial Date</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Type</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($burials as $burial)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $burial->deceased->first_name }} {{ $burial->deceased->last_name }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">
                    Lot {{ $burial->lot->lot_number }}, Section {{ $burial->lot->section }}, Row {{ $burial->lot->row }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($burial->burial_date)->format('M d, Y') }}</td>
                <td class="px-6 py-4 text-sm text-gray-600 capitalize">{{ $burial->burial_type }}</td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.burials.show', $burial) }}" class="bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-gray-200 transition">View</a>
                        <a href="{{ route('admin.burials.edit', $burial) }}" class="bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-blue-100 transition">Edit</a>
                        <form method="POST" action="{{ route('admin.burials.destroy', $burial) }}" onsubmit="return confirm('Are you sure?')">
                            @csrf @method('DELETE')
                            <button class="bg-red-50 text-red-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-red-100 transition">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-400">No burial records found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-gray-100">{{ $burials->links() }}</div>
</div>
@endsection