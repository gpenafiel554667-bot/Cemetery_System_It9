@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Update Inquiry Status</h1>
</div>

<div class="bg-white rounded-xl shadow p-6 max-w-2xl">
    <div class="mb-4 grid grid-cols-2 gap-4 text-sm text-gray-600">
        <div><span class="font-semibold">Name:</span> {{ $inquiry->name }}</div>
        <div><span class="font-semibold">Contact:</span> {{ $inquiry->contact_number }}</div>
        <div class="col-span-2"><span class="font-semibold">Message:</span> {{ $inquiry->message }}</div>
    </div>

    <form method="POST" action="{{ route('admin.inquiries.update', $inquiry) }}">
        @csrf @method('PUT')
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Status</label>
            <select name="status" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                <option value="pending" {{ $inquiry->status === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="read" {{ $inquiry->status === 'read' ? 'selected' : '' }}>Read</option>
                <option value="responded" {{ $inquiry->status === 'responded' ? 'selected' : '' }}>Responded</option>
            </select>
            @error('status')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-gray-900 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition">Update Status</button>
            <a href="{{ route('admin.inquiries.index') }}" class="bg-gray-200 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-300 transition">Cancel</a>
        </div>
    </form>
</div>
@endsection