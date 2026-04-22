@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Edit Lot</h1>
</div>

<div class="bg-white rounded-xl shadow p-6 max-w-2xl">
    <form method="POST" action="{{ route('admin.lots.update', $lot) }}">
        @csrf @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Lot Number</label>
                <input type="text" name="lot_number" value="{{ old('lot_number', $lot->lot_number) }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400" required>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Section</label>
                <input type="text" name="section" value="{{ old('section', $lot->section) }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400" required>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Row</label>
                <input type="text" name="row" value="{{ old('row', $lot->row) }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400" required>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Price</label>
                <input type="number" name="price" value="{{ old('price', $lot->price) }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400" required>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Type</label>
                <select name="type" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                    <option value="ground" {{ $lot->type == 'ground' ? 'selected' : '' }}>Ground</option>
                    <option value="mausoleum" {{ $lot->type == 'mausoleum' ? 'selected' : '' }}>Mausoleum</option>
                    <option value="columbarium" {{ $lot->type == 'columbarium' ? 'selected' : '' }}>Columbarium</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Status</label>
                <select name="status" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                    <option value="available" {{ $lot->status == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="occupied" {{ $lot->status == 'occupied' ? 'selected' : '' }}>Occupied</option>
                    <option value="reserved" {{ $lot->status == 'reserved' ? 'selected' : '' }}>Reserved</option>
                </select>
            </div>
            <div class="col-span-2">
                <label class="block text-gray-700 font-semibold mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400">{{ old('description', $lot->description) }}</textarea>
            </div>
        </div>
        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-gray-900 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition">Update Lot</button>
            <a href="{{ route('admin.lots.index') }}" class="bg-gray-200 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-300 transition">Cancel</a>
        </div>
    </form>
</div>
@endsection