@extends('layouts.staff')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Add Deceased Record</h1>
</div>

<div class="bg-white rounded-xl shadow p-6 max-w-2xl">
    <form method="POST" action="{{ route('staff.deceased.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-semibold mb-1">First Name</label>
                <input type="text" name="first_name" value="{{ old('first_name') }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                @error('first_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Last Name</label>
                <input type="text" name="last_name" value="{{ old('last_name') }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                @error('last_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Date of Birth</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                @error('date_of_birth')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Date of Death</label>
                <input type="date" name="date_of_death" value="{{ old('date_of_death') }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                @error('date_of_death')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="col-span-2">
                <label class="block text-gray-700 font-semibold mb-1">Cause of Death</label>
                <input type="text" name="cause_of_death" value="{{ old('cause_of_death') }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="col-span-2">
                <label class="block text-gray-700 font-semibold mb-1">Photo</label>
                <input type="file" name="photo" class="w-full border rounded-lg px-4 py-2">
            </div>
        </div>
        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-blue-900 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Save Record</button>
            <a href="{{ route('staff.deceased.index') }}" class="bg-gray-200 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-300 transition">Cancel</a>
        </div>
    </form>
</div>
@endsection