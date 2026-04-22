@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Search Deceased Records</h1>
        <p class="text-gray-500 mt-1 text-sm">Browse or search for a deceased individual by name.</p>
    </div>

    <!-- Search Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <form method="GET" action="{{ route('public.search') }}">
            <div class="flex gap-4">
                <input type="text" name="query" value="{{ $query ?? '' }}"
                    placeholder="Enter first name or last name..."
                    class="flex-1 border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400">
                <button type="submit" class="bg-gray-900 text-white px-8 py-3 rounded-lg hover:bg-gray-700 transition text-sm font-semibold">Search</button>
                @if($query)
                    <a href="{{ route('public.search') }}" class="bg-gray-100 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-200 transition text-sm font-semibold">Clear</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Results -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide">
                    {{ $query ? 'Search Results for "' . $query . '"' : 'All Deceased Records' }}
                </h2>
                <p class="text-gray-500 text-xs mt-1">{{ $deceased->total() }} record(s) found</p>
            </div>
        </div>

        <div class="divide-y divide-gray-100">
            @forelse($deceased as $record)
            <div class="p-6 hover:bg-gray-50 transition">
                <div class="flex items-start gap-6">
                    @if($record->photo)
                        <img src="{{ asset('storage/'.$record->photo) }}" class="w-20 h-20 object-cover rounded-lg border border-gray-200 flex-shrink-0">
                    @else
                        <div class="w-20 h-20 bg-gray-100 rounded-lg border border-gray-200 flex items-center justify-center flex-shrink-0">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    @endif
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-gray-900">{{ $record->first_name }} {{ $record->last_name }}</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-3">
                            <div>
                                <p class="text-gray-400 text-xs uppercase tracking-wide">Date of Birth</p>
                                <p class="font-semibold text-gray-800 text-sm mt-1">{{ \Carbon\Carbon::parse($record->date_of_birth)->format('F d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400 text-xs uppercase tracking-wide">Date of Death</p>
                                <p class="font-semibold text-gray-800 text-sm mt-1">{{ \Carbon\Carbon::parse($record->date_of_death)->format('F d, Y') }}</p>
                            </div>
                            @if($record->burial)
                            <div>
                                <p class="text-gray-400 text-xs uppercase tracking-wide">Burial Date</p>
                                <p class="font-semibold text-gray-800 text-sm mt-1">{{ \Carbon\Carbon::parse($record->burial->burial_date)->format('F d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-400 text-xs uppercase tracking-wide">Lot Location</p>
                                <p class="font-semibold text-gray-800 text-sm mt-1">
                                    @if($record->burial->lot)
                                        Section {{ $record->burial->lot->section }}, Row {{ $record->burial->lot->row }}, Lot {{ $record->burial->lot->lot_number }}
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                            @else
                            <div>
                                <p class="text-gray-400 text-xs uppercase tracking-wide">Burial Status</p>
                                <p class="font-semibold text-gray-800 text-sm mt-1">
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded-full text-xs">Pending Burial</span>
                                </p>
                            </div>
                            @endif
                        </div>
                        @if($record->cause_of_death)
                        <p class="text-gray-400 text-sm mt-3">Cause of Death: {{ $record->cause_of_death }}</p>
                        @endif

                        <!-- Family Members -->
                        @if($record->families && $record->families->count() > 0)
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <p class="text-gray-400 text-xs uppercase tracking-wide mb-2">Family Members</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($record->families as $family)
                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs">
                                    {{ $family->first_name }} {{ $family->last_name }} ({{ $family->relationship }})
                                </span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="p-12 text-center">
                <p class="text-gray-500 text-lg font-semibold">No records found</p>
                <p class="text-gray-400 text-sm mt-2">Try searching with a different name.</p>
            </div>
            @endforelse
        </div>

        @if($deceased->hasPages())
        <div class="p-4 border-t border-gray-200">
            {{ $deceased->appends(['query' => $query])->links() }}
        </div>
        @endif
    </div>
</div>
@endsection