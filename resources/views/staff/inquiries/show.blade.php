@extends('layouts.staff')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h1 class="text-3xl font-bold text-gray-800">Inquiry Details</h1>
    <a href="{{ route('staff.inquiries.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300">Back</a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg mb-4">{{ session('success') }}</div>
@endif

<div class="grid grid-cols-1 gap-6 max-w-3xl">

    {{-- Inquiry Info --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-bold text-gray-700 mb-4">From</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-gray-500 text-sm">Name</p>
                <p class="font-semibold text-gray-800">{{ $inquiry->name }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Contact Number</p>
                <p class="font-semibold text-gray-800">{{ $inquiry->contact_number }}</p>
            </div>
            <div class="col-span-2">
                <p class="text-gray-500 text-sm">Email</p>
                <p class="font-semibold text-gray-800">{{ $inquiry->email ?? 'N/A' }}</p>
            </div>
            <div class="col-span-2">
                <p class="text-gray-500 text-sm">Message</p>
                <p class="font-semibold text-gray-800 mt-1 leading-relaxed whitespace-pre-line">{{ $inquiry->message }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Current Status</p>
                <span class="text-xs px-2 py-1 rounded-full
                    {{ $inquiry->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                    {{ $inquiry->status === 'read' ? 'bg-blue-100 text-blue-700' : '' }}
                    {{ $inquiry->status === 'responded' ? 'bg-green-100 text-green-700' : '' }}">
                    {{ ucfirst($inquiry->status) }}
                </span>
            </div>
            @if($inquiry->responded_at)
                <div>
                    <p class="text-gray-500 text-sm">Responded At</p>
                    <p class="font-semibold text-gray-800">{{ $inquiry->responded_at->format('M d, Y h:i A') }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Response --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-lg font-bold text-gray-700 mb-4">Response</h2>
        <form method="POST" action="{{ route('staff.inquiries.update', $inquiry) }}">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Status</label>
                    <select name="status" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="pending" {{ $inquiry->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="read" {{ $inquiry->status === 'read' ? 'selected' : '' }}>Read</option>
                        <option value="responded" {{ $inquiry->status === 'responded' ? 'selected' : '' }}>Responded</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Reply Notes</label>
                    <textarea name="response" rows="5" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Type the response or action taken here...">{{ old('response', $inquiry->response) }}</textarea>
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="bg-blue-900 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Save Response</button>
                    @if($inquiry->email)
                        <a href="mailto:{{ $inquiry->email }}?subject={{ rawurlencode('Response to your inquiry') }}&body={{ rawurlencode(old('response', $inquiry->response ?? '')) }}" class="bg-blue-50 text-blue-700 px-6 py-2 rounded-lg hover:bg-blue-100 transition">Email</a>
                    @endif
                </div>
            </div>
        </form>
    </div>

</div>
@endsection
