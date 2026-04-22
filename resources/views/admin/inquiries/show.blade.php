@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-800">Inquiry Detail</h1>
    <div class="flex gap-2">
        <a href="{{ route('admin.inquiries.edit', $inquiry) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">Edit Status</a>
        <a href="{{ route('admin.inquiries.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300">Back</a>
    </div>
</div>

<div class="bg-white rounded-xl shadow p-6 max-w-2xl">
    <div class="grid grid-cols-2 gap-4">
        <div>
            <p class="text-gray-500 text-sm">Name</p>
            <p class="font-semibold text-gray-800">{{ $inquiry->name }}</p>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Contact Number</p>
            <p class="font-semibold text-gray-800">{{ $inquiry->contact_number }}</p>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Email</p>
            <p class="font-semibold text-gray-800">{{ $inquiry->email ?? 'N/A' }}</p>
        </div>
        <div>
            <p class="text-gray-500 text-sm">Status</p>
            @if($inquiry->status === 'pending')
                <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full text-xs font-semibold">Pending</span>
            @elseif($inquiry->status === 'read')
                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-semibold">Read</span>
            @else
                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-xs font-semibold">Responded</span>
            @endif
        </div>
        <div>
            <p class="text-gray-500 text-sm">Date Submitted</p>
            <p class="font-semibold text-gray-800">{{ $inquiry->created_at->format('M d, Y h:i A') }}</p>
        </div>
        <div class="col-span-2">
            <p class="text-gray-500 text-sm">Message</p>
            <p class="font-semibold text-gray-800 whitespace-pre-line">{{ $inquiry->message }}</p>
        </div>
    </div>
</div>
@endsection