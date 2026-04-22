@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-800">User Management</h1>
    <button onclick="document.getElementById('createModal').classList.remove('hidden')"
        class="bg-gray-900 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">➕ Add User</button>
</div>

@if(session('success'))
    <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-lg">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded-lg">{{ session('error') }}</div>
@endif

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="text-left px-6 py-4 text-gray-600">Name</th>
                <th class="text-left px-6 py-4 text-gray-600">Email</th>
                <th class="text-left px-6 py-4 text-gray-600">Role</th>
                <th class="text-left px-6 py-4 text-gray-600">Created</th>
                <th class="text-left px-6 py-4 text-gray-600">Password</th>
                <th class="text-left px-6 py-4 text-gray-600">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr class="border-b hover:bg-gray-50">
                <td class="px-6 py-4 font-medium text-gray-800">{{ $user->name }}</td>
                <td class="px-6 py-4">{{ $user->email }}</td>
                <td class="px-6 py-4">
                    @if($user->role === 'admin')
                        <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded-full text-xs font-semibold">Admin</span>
                    @else
                        <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded-full text-xs font-semibold">Staff</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-gray-500 text-sm">{{ $user->created_at->format('M d, Y') }}</td>
                <td class="px-6 py-4">
                    <button
                        onclick="openResetModal({{ $user->id }}, '{{ $user->name }}')"
                        class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">
                        Reset Password
                    </button>
                </td>
                <td class="px-6 py-4">
                    @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this user?')">
                            @csrf @method('DELETE')
                            <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                        </form>
                    @else
                        <span class="text-gray-400 text-sm">You</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-400">No users found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4">{{ $users->links() }}</div>
</div>

{{-- Create User Modal --}}
<div id="createModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Add New User</h2>
            <button onclick="document.getElementById('createModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>

        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                    @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                    @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Password</label>
                    <input type="password" name="password" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                    @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Role</label>
                    <select name="role" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                        <option value="">-- Select Role --</option>
                        <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-gray-900 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition">Create User</button>
                <button type="button" onclick="document.getElementById('createModal').classList.add('hidden')"
                    class="bg-gray-200 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-300 transition">Cancel</button>
            </div>
        </form>
    </div>
</div>

{{-- Reset Password Modal --}}
<div id="resetModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Reset Password</h2>
            <button onclick="document.getElementById('resetModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>
        <p class="text-sm text-gray-500 mb-4">Setting new password for <span id="resetUserName" class="font-semibold text-gray-800"></span>.</p>

        <form method="POST" id="resetPasswordForm" action="">
            @csrf
            @method('PATCH')
            <div class="space-y-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">New Password</label>
                    <input type="password" name="new_password"
                        class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400"
                        placeholder="Min. 6 characters" required>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Confirm New Password</label>
                    <input type="password" name="new_password_confirmation"
                        class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400"
                        placeholder="Repeat password" required>
                </div>
            </div>
            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600 transition">Save Password</button>
                <button type="button" onclick="document.getElementById('resetModal').classList.add('hidden')"
                    class="bg-gray-200 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-300 transition">Cancel</button>
            </div>
        </form>
    </div>
</div>

{{-- Keep create modal open on validation error --}}
@if($errors->any())
<script>
    document.getElementById('createModal').classList.remove('hidden');
</script>
@endif

<script>
    function openResetModal(userId, userName) {
        document.getElementById('resetUserName').textContent = userName;
        document.getElementById('resetPasswordForm').action = '/admin/users/' + userId + '/reset-password';
        document.getElementById('resetModal').classList.remove('hidden');
    }
</script>

@endsection