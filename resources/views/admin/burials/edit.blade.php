@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Edit Burial Record</h1>
</div>

<div class="bg-white rounded-xl shadow p-6 max-w-2xl">
    <form method="POST" action="{{ route('admin.burials.update', $burial) }}">
        @csrf @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <label class="block text-gray-700 font-semibold mb-1">Deceased Person</label>
                <select name="deceased_id" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                    <option value="">— Select Deceased —</option>
                    @foreach($deceased as $d)
                        <option value="{{ $d->id }}" {{ old('deceased_id', $burial->deceased_id) == $d->id ? 'selected' : '' }}>
                            {{ $d->first_name }} {{ $d->last_name }}
                        </option>
                    @endforeach
                </select>
                @error('deceased_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="col-span-2">
                <label class="block text-gray-700 font-semibold mb-1">Lot / Plot</label>
                <select name="lot_id" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                    <option value="">— Select Lot —</option>
                    @foreach($lots as $lot)
                        <option value="{{ $lot->id }}" {{ old('lot_id', $burial->lot_id) == $lot->id ? 'selected' : '' }}>
                            Section {{ $lot->section }} — Row {{ $lot->row }} — Lot {{ $lot->lot_number }} ({{ ucfirst($lot->type) }}) — {{ ucfirst($lot->status) }}
                        </option>
                    @endforeach
                </select>
                @error('lot_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Burial Date</label>
                <input type="date" name="burial_date" value="{{ old('burial_date', $burial->burial_date) }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                @error('burial_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-1">Burial Type</label>
                <select name="burial_type" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                    <option value="ground" {{ old('burial_type', $burial->burial_type) == 'ground' ? 'selected' : '' }}>Ground</option>
                    <option value="mausoleum" {{ old('burial_type', $burial->burial_type) == 'mausoleum' ? 'selected' : '' }}>Mausoleum</option>
                    <option value="columbarium" {{ old('burial_type', $burial->burial_type) == 'columbarium' ? 'selected' : '' }}>Columbarium</option>
                </select>
                @error('burial_type')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="col-span-2">
                <label class="block text-gray-700 font-semibold mb-1">Notes</label>
                <textarea name="notes" rows="3" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400">{{ old('notes', $burial->notes) }}</textarea>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-gray-900 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition">Update Record</button>
            <a href="{{ route('admin.burials.index') }}" class="bg-gray-200 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-300 transition">Cancel</a>
        </div>
    </form>
</div>
@endsection