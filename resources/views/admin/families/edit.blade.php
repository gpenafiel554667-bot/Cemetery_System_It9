@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Edit Family Record</h1>
</div>

<div class="bg-white rounded-xl shadow p-6 max-w-2xl">
    <form method="POST" action="{{ route('admin.families.update', $family) }}">
        @csrf @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-semibold mb-1">First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name', $family->first_name) }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                @error('first_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name', $family->last_name) }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                @error('last_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Relationship</label>
                <input type="text" name="relationship" value="{{ old('relationship', $family->relationship) }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                @error('relationship')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Contact Number</label>
                <input type="text" name="contact_number" value="{{ old('contact_number', $family->contact_number) }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                @error('contact_number')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $family->email) }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400">
                @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Linked Deceased</label>
                <select name="deceased_id" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                    <option value="">-- Select Deceased --</option>
                    @foreach($deceased as $d)
                        <option value="{{ $d->id }}" {{ old('deceased_id', $family->deceased_id) == $d->id ? 'selected' : '' }}>
                            {{ $d->first_name }} {{ $d->last_name }}
                        </option>
                    @endforeach
                </select>
                @error('deceased_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="col-span-2">
                <label class="block text-gray-700 font-semibold mb-1">Address</label>
                <textarea name="address" rows="3" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400">{{ old('address', $family->address) }}</textarea>
                @error('address')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-gray-900 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition">Update Record</button>
            <a href="{{ route('admin.families.index') }}" class="bg-gray-200 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-300 transition">Cancel</a>
        </div>
    </form>
</div>
@endsection