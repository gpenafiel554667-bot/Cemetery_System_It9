@extends('layouts.staff')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Inquiries</h1>
        <p class="text-gray-500 text-sm mt-1">Manage all public inquiries and messages.</p>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Total Inquiries</p>
        <h2 class="text-2xl font-bold text-gray-900 mt-1">{{ $inquiries->total() }}</h2>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Pending</p>
        <h2 class="text-2xl font-bold text-red-600 mt-1">{{ \App\Models\Inquiry::where('status','pending')->count() }}</h2>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Responded</p>
        <h2 class="text-2xl font-bold text-green-600 mt-1">{{ \App\Models\Inquiry::where('status','responded')->count() }}</h2>
    </div>
</div>

<!-- Table -->
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide">All Inquiries</h2>
        <span class="text-xs text-gray-400">{{ $inquiries->total() }} total</span>
    </div>
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Name</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Contact</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Message</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Date</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($inquiries as $inquiry)
            <tr class="hover:bg-gray-50 transition {{ $inquiry->status === 'pending' ? 'bg-yellow-50' : '' }}">
                <td class="px-6 py-4">
                    <p class="text-sm font-semibold text-gray-900">{{ $inquiry->name }}</p>
                    @if($inquiry->email)
                        <p class="text-xs text-gray-400 mt-0.5">{{ $inquiry->email }}</p>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $inquiry->contact_number }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($inquiry->message, 50) }}</td>
                <td class="px-6 py-4">
                    @if($inquiry->status === 'pending')
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Pending</span>
                    @elseif($inquiry->status === 'read')
                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">Read</span>
                    @else
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Responded</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $inquiry->created_at->format('M d, Y') }}</td>
                <td class="px-6 py-4">
                    <button
                        type="button"
onclick="openDeleteModal({{ $inquiry->id }})"
                        class="bg-red-50 text-red-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-red-100 transition">Delete</button>
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">No inquiries found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-gray-100">{{ $inquiries->links() }}</div>
</div>
<!-- Inquiry Delete Modal -->
<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" style="display:none;">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md mx-4 text-center">
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        <h2 class="text-lg font-bold text-gray-900 mb-2">Delete Record</h2>
        <p class="text-gray-500 text-sm mb-6">Are you sure you want to delete this inquiry? This action cannot be undone.</p>
        <form id="deleteForm" method="POST" action="">
            @csrf @method('DELETE')
            <div class="flex gap-3 justify-center">
                <button type="submit" class="bg-red-600 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-red-700 transition">Yes, Delete</button>
                <button type="button" onclick="closeDeleteModal()" class="bg-gray-100 text-gray-800 px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-200 transition">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function openDeleteModal(id) {
        const form = document.getElementById('deleteForm');
        form.action = '/staff/inquiries/' + id;

        const modal = document.getElementById('deleteModal');
        modal.style.display = 'flex';
        modal.classList.remove('hidden');
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        modal.style.display = 'none';
        modal.classList.add('hidden');
    }

    window.onclick = function(e) {
        if (e.target && e.target.id === 'deleteModal') {
            closeDeleteModal();
        }
    };
</script>

@endsection
