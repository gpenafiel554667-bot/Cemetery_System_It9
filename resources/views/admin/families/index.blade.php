@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Family Records</h1>
        <p class="text-gray-500 text-sm mt-1">Manage next of kin and family contact information.</p>
    </div>
    <a href="{{ route('admin.families.create') }}" class="bg-gray-900 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">Add Family</a>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Total Family Records</p>
        <h2 class="text-2xl font-bold text-gray-900 mt-1">{{ $families->total() }}</h2>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Linked Deceased</p>
        <h2 class="text-2xl font-bold text-gray-900 mt-1">{{ \App\Models\Family::distinct('deceased_id')->count() }}</h2>
    </div>
</div>

<!-- Table -->
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide">All Family Records</h2>
        <span class="text-xs text-gray-400">{{ $families->total() }} total</span>
    </div>
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Name</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Relationship</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Contact Number</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Linked Deceased</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($families as $family)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    <p class="text-sm font-semibold text-gray-900">{{ $family->first_name }} {{ $family->last_name }}</p>
                    @if($family->email)
                        <p class="text-xs text-gray-400 mt-0.5">{{ $family->email }}</p>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold">{{ $family->relationship }}</span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $family->contact_number }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $family->deceased->first_name }} {{ $family->deceased->last_name }}</td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">
                        <a href="{{ route('admin.families.show', $family) }}" class="bg-gray-100 text-gray-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-gray-200 transition">View</a>
                        <a href="{{ route('admin.families.edit', $family) }}" class="bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-blue-100 transition">Edit</a>
                        <form method="POST" action="{{ route('admin.families.destroy', $family) }}" onsubmit="return confirm('Are you sure?')">
                            @csrf @method('DELETE')
                            <button class="bg-red-50 text-red-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-red-100 transition">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-400">No family records found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-gray-100">{{ $families->links() }}</div>
</div>
@endsection