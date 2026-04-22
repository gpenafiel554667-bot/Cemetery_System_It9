@extends('layouts.staff')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-800">Burial Record</h1>
    <div class="flex gap-2">
        <a href="{{ route('staff.burials.edit', $burial) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">Edit</a>
        <a href="{{ route('staff.burials.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300">Back</a>
    </div>
</div>

<div class="bg-white rounded-xl shadow p-6 max-w-2xl">
    <div class="grid grid-cols-2 gap-4">
        <div>
            <p class="text-gray-500 text-sm">Deceased</p>
            <p class="font-semibold text-gray-800">{{ $burial->deceased->first_name }} {{ $burial->deceased->last_name }}</p>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Lot</p>
            <p class="font-semibold text-gray-800">{{ $burial->lot->section }} - {{ $burial->lot->lot_number }}</p>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Burial Date</p>
            <p class="font-semibold text-gray-800">{{ $burial->burial_date }}</p>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Burial Type</p>
            <p class="font-semibold text-gray-800 capitalize">{{ $burial->burial_type }}</p>
        </div>
        <div class="col-span-2">
            <p class="text-gray-500 text-sm">Notes</p>
            <p class="font-semibold text-gray-800">{{ $burial->notes ?? 'N/A' }}</p>
        </div>
    </div>
</div>
@endsection