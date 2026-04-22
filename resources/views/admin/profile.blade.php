@extends('layouts.admin')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">My Profile</h1>
    <p class="text-gray-500 text-sm mt-1">Manage your account information and settings.</p>
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
        <span class="inline-block mt-2 bg-gray-900 text-white text-xs px-3 py-1 rounded-full uppercase tracking-wide">Administrator</span>

        <div class="mt-6 pt-6 border-t border-gray-100">
            <a href="{{ route('admin.profile.requests') }}" class="block w-full text-center bg-gray-100 text-gray-800 py-2 rounded-lg text-sm font-semibold hover:bg-gray-200 transition">
                View Staff Requests
            </a>
        </div>
    </div>

    <!-- Right Column -->
    <div class="md:col-span-2 space-y-6">

        <!-- Form 1: Profile Info (name, email, photo) -->
        <div class="bg-white rounded-xl border border-gray-200 p-8">
            <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-6">Update Profile Info</h2>

            <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="form_type" value="info">

                <div class="grid grid-cols-1 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                        @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Profile Photo</label>
                        @if(auth()->user()->photo)
                            <img src="{{ asset('storage/' . auth()->user()->photo) }}" class="w-16 h-16 rounded-lg object-cover mb-2 border border-gray-200">
                        @endif
                        <input type="file" name="photo" accept="image/*"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none">
                        @error('photo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-gray-900 text-white px-8 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">
                        Save Profile
                    </button>
                </div>
            </form>
        </div>

        <!-- Form 2: Change Password -->
        <div class="bg-white rounded-xl border border-gray-200 p-8">
            <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-2">Change Password</h2>
            <p class="text-gray-400 text-xs mb-6">Leave blank if you don't want to change your password.</p>

            <form method="POST" action="{{ route('admin.profile.update') }}">
                @csrf
                <input type="hidden" name="form_type" value="password">

                <div class="grid grid-cols-1 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">New Password</label>
                        <input type="password" name="password"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400"
                            placeholder="Enter new password">
                        @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Confirm New Password</label>
                        <input type="password" name="password_confirmation"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400"
                            placeholder="Confirm new password">
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-gray-900 text-white px-8 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">
                        Update Password
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection