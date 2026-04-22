@extends('layouts.staff')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">My Profile</h1>
    <p class="text-gray-500 text-sm mt-1">Submit a request to update your profile information.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8">

    <!-- Profile Card -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 text-center">
        <div class="mb-4">
            @if(auth()->user()->photo)
                <img src="{{ asset('storage/' . auth()->user()->photo) }}" class="w-24 h-24 rounded-full object-cover mx-auto border-4 border-gray-200">
            @else
                <div class="w-24 h-24 rounded-full bg-gray-900 flex items-center justify-center mx-auto text-white text-3xl font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            @endif
        </div>
        <h2 class="text-lg font-bold text-gray-900">{{ auth()->user()->name }}</h2>
        <p class="text-gray-500 text-sm">{{ auth()->user()->email }}</p>
        <span class="inline-block mt-2 bg-gray-700 text-white text-xs px-3 py-1 rounded-full uppercase tracking-wide">Staff</span>

        @if($pendingRequest)
        <div class="mt-6 pt-6 border-t border-gray-100">
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                <p class="text-yellow-700 text-xs font-semibold">You have a pending request</p>
                <p class="text-yellow-600 text-xs mt-1">Submitted {{ $pendingRequest->created_at->format('M d, Y') }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Request Form -->
    <div class="md:col-span-2 space-y-6">

        @if($pendingRequest)
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
            <h3 class="font-bold text-yellow-800 text-sm mb-1">Pending Request</h3>
            <p class="text-yellow-700 text-xs">You have a pending profile change request. You cannot submit another request until the current one is reviewed by the admin.</p>
        </div>
        @endif

        <!-- Submit Request Form -->
        <div class="bg-white rounded-xl border border-gray-200 p-8">
            <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-2">Request Profile Changes</h2>
            <p class="text-gray-400 text-xs mb-6">Fill in only the fields you want to change. Leave blank to keep current values. Your request will be reviewed by the admin.</p>

            @if(!$pendingRequest)
            <form method="POST" action="{{ route('staff.profile.request') }}" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">New Name <span class="text-gray-400 font-normal">(optional)</span></label>
                        <input type="text" name="requested_name" value="{{ old('requested_name') }}"
                            placeholder="Enter new name"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400">
                        @error('requested_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">New Email <span class="text-gray-400 font-normal">(optional)</span></label>
                        <input type="email" name="requested_email" value="{{ old('requested_email') }}"
                            placeholder="Enter new email"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400">
                        @error('requested_email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">New Password <span class="text-gray-400 font-normal">(optional)</span></label>
                        <input type="password" name="requested_password"
                            placeholder="Enter new password"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400">
                        @error('requested_password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Confirm New Password</label>
                        <input type="password" name="requested_password_confirmation"
                            placeholder="Confirm new password"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">New Profile Photo <span class="text-gray-400 font-normal">(optional)</span></label>
                        <input type="file" name="requested_photo" accept="image/*"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none">
                        @error('requested_photo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-gray-900 text-white px-8 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">
                        Submit Request
                    </button>
                </div>
            </form>
            @else
            <div class="text-center py-8">
                <p class="text-gray-500 text-sm">You cannot submit a new request while one is pending.</p>
            </div>
            @endif
        </div>

        <!-- Request History -->
        @if($requests->count() > 0)
        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide">Request History</h2>
            </div>
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Date</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Changes Requested</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Admin Note</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($requests as $req)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $req->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <ul class="space-y-1">
                                @if($req->requested_name)<li class="text-xs">Name: {{ $req->requested_name }}</li>@endif
                                @if($req->requested_email)<li class="text-xs">Email: {{ $req->requested_email }}</li>@endif
                                @if($req->requested_password)<li class="text-xs">Password: Yes</li>@endif
                                @if($req->requested_photo)<li class="text-xs">Photo: Yes</li>@endif
                            </ul>
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
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $req->admin_note ?? '—' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>
@endsection