@extends('layouts.staff')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Add Burial Record</h1>
    <p class="text-gray-500 text-sm mt-1">Only unburied deceased and available lots are shown.</p>
</div>

<div class="bg-white rounded-xl border border-gray-200 p-8 max-w-2xl">
    <form method="POST" action="{{ route('staff.burials.store') }}">
        @csrf
        <div class="grid grid-cols-2 gap-5">

            <div class="col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Deceased Person</label>
                <select name="deceased_id" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                    <option value="">Select Deceased</option>
                    @forelse($deceased as $d)
                        <option value="{{ $d->id }}" {{ old('deceased_id') == $d->id ? 'selected' : '' }}>
                            {{ $d->first_name }} {{ $d->last_name }} — Died: {{ \Carbon\Carbon::parse($d->date_of_death)->format('M d, Y') }}
                        </option>
                    @empty
                        <option disabled>All deceased records already have burial assignments.</option>
                    @endforelse
                </select>
                @if($deceased->isEmpty())
                    <p class="text-yellow-600 text-xs mt-1">All deceased records already have burial assignments.</p>
                @endif
                @error('deceased_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Lot / Plot</label>
                <select name="lot_id" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                    <option value="">Select Available Lot</option>
                    @forelse($lots as $lot)
                        <option value="{{ $lot->id }}" {{ old('lot_id') == $lot->id ? 'selected' : '' }}>
                            Lot {{ $lot->lot_number }} — Section {{ $lot->section }}, Row {{ $lot->row }} ({{ ucfirst($lot->type) }}) — PHP {{ number_format($lot->price, 2) }}
                        </option>
                    @empty
                        <option disabled>No available lots.</option>
                    @endforelse
                </select>
                @if($lots->isEmpty())
                    <p class="text-yellow-600 text-xs mt-1">No available lots. Please add or free up a lot first.</p>
                @endif
                @error('lot_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Burial Date</label>
                <input type="date" name="burial_date" value="{{ old('burial_date') }}"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                @error('burial_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Burial Type</label>
                <select name="burial_type" class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                    <option value="">Select Type</option>
                    <option value="ground" {{ old('burial_type') == 'ground' ? 'selected' : '' }}>Ground</option>
                    <option value="mausoleum" {{ old('burial_type') == 'mausoleum' ? 'selected' : '' }}>Mausoleum</option>
                    <option value="columbarium" {{ old('burial_type') == 'columbarium' ? 'selected' : '' }}>Columbarium</option>
                </select>
                @error('burial_type')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Notes</label>
                <textarea name="notes" rows="3"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400"
                    placeholder="Optional notes about this burial...">{{ old('notes') }}</textarea>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-gray-900 text-white px-8 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">Save Record</button>
            <a href="{{ route('staff.burials.index') }}" class="bg-gray-100 text-gray-800 px-8 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-200 transition">Cancel</a>
        </div>
    </form>
</div>
@endsection