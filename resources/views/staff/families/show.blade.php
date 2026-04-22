@extends('layouts.staff')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-800">Family Record</h1>
    <div class="flex gap-2">
        <a href="{{ route('staff.families.edit', $family) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">Edit</a>
        <a href="{{ route('staff.families.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300">Back</a>
    </div>
</div>

<div class="bg-white rounded-xl shadow p-6 max-w-2xl">
    <div class="grid grid-cols-2 gap-4">
        <div>
            <p class="text-gray-500 text-sm">First Name</p>
            <p class="font-semibold text-gray-800">{{ $family->first_name }}</p>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Last Name</p>
            <p class="font-semibold text-gray-800">{{ $family->last_name }}</p>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Relationship</p>
            <p class="font-semibold text-gray-800">{{ $family->relationship }}</p>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Contact Number</p>
            <p class="font-semibold text-gray-800">{{ $family->contact_number }}</p>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Email</p>
            <p class="font-semibold text-gray-800">{{ $family->email ?? 'N/A' }}</p>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Deceased</p>
            <p class="font-semibold text-gray-800">{{ $family->deceased->first_name }} {{ $family->deceased->last_name }}</p>
        </div>
        <div class="col-span-2">
            <p class="text-gray-500 text-sm">Address</p>
            <p class="font-semibold text-gray-800">{{ $family->address ?? 'N/A' }}</p>
        </div>
    </div>
</div>
@endsection