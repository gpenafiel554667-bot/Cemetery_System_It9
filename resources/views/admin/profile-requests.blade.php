@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">Staff Profile Requests</h1>
    <p class="text-gray-500 text-sm mt-1">Review and approve or reject staff profile change requests.</p>
</div>

<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Staff</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Requested Name</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Requested Email</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Password</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Photo</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Date</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($requests as $req)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        @if($req->user->photo)
                            <img src="{{ asset('storage/' . $req->user->photo) }}" class="w-8 h-8 rounded-full object-cover">
                        @else
                            <div class="w-8 h-8 rounded-full bg-gray-900 flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr($req->user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $req->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $req->user->email }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $req->requested_name ?? 'No change' }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $req->requested_email ?? 'No change' }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $req->requested_password ? 'Yes' : 'No change' }}</td>
                <td class="px-6 py-4">
                    @if($req->requested_photo)
                        <img src="{{ asset('storage/' . $req->requested_photo) }}" class="w-10 h-10 rounded-lg object-cover border border-gray-200">
                    @else
                        <span class="text-xs text-gray-400">No change</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    @if($req->status === 'pending')
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Pending</span>
                    @elseif($req->status === 'approved')
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Approved</span>
                    @else
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">Rejected</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $req->created_at->format('M d, Y') }}</td>
                <td class="px-6 py-4">
                    @if($req->status === 'pending')
                    <div class="flex gap-2">
                        <form method="POST" action="{{ route('admin.profile.approve', $req) }}">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-green-700 transition">Approve</button>
                        </form>
                        <form method="POST" action="{{ route('admin.profile.reject', $req) }}">
                            @csrf
                            <input type="hidden" name="admin_note" value="Request rejected by admin.">
                            <button type="submit" class="bg-red-600 text-white px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-red-700 transition" onclick="return confirm('Reject this request?')">Reject</button>
                        </form>
                    </div>
                    @else
                        @if($req->admin_note)
                            <p class="text-xs text-gray-400">{{ $req->admin_note }}</p>
                        @else
                            <span class="text-xs text-gray-400">—</span>
                        @endif
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-6 py-8 text-center text-sm text-gray-400">No profile requests found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $requests->links() }}</div>
</div>
@endsection