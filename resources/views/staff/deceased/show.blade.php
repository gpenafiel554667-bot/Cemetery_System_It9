@extends('layouts.staff')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-800">Deceased Record</h1>
    <div class="flex gap-2">
        <a href="{{ route('staff.deceased.edit', $deceased) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">Edit</a>
        <a href="{{ route('staff.deceased.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300">Back</a>
    </div>
</div>

<div class="bg-white rounded-xl shadow p-6 max-w-2xl">
    @if($deceased->photo)
        <img src="{{ asset('storage/'.$deceased->photo) }}" class="w-32 h-32 object-cover rounded-lg mb-4">
    @endif
    <div class="grid grid-cols-2 gap-4">
        <div>
            <p class="text-gray-500 text-sm">First Name</p>
            <p class="font-semibold text-gray-800">{{ $deceased->first_name }}</p>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Last Name</p>
            <p class="font-semibold text-gray-800">{{ $deceased->last_name }}</p>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Date of Birth</p>
            <p class="font-semibold text-gray-800">{{ $deceased->date_of_birth }}</p>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Date of Death</p>
            <p class="font-semibold text-gray-800">{{ $deceased->date_of_death }}</p>
        </div>
        <div class="col-span-2">
            <p class="text-gray-500 text-sm">Cause of Death</p>
            <p class="font-semibold text-gray-800">{{ $deceased->cause_of_death ?? 'N/A' }}</p>
        </div>
    </div>
</div>
@endsection