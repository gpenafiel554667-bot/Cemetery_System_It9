@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Deceased Records</h1>
        <p class="text-gray-500 text-sm mt-1">Manage all deceased records in the system.</p>
    </div>
    <a href="{{ route('admin.deceased.create') }}" class="bg-gray-900 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">Add Record</a>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Total Records</p>
        <h2 class="text-2xl font-bold text-gray-900 mt-1">{{ $deceased->total() }}</h2>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-gray-500 text-xs uppercase tracking-wide">With Burial</p>
        <h2 class="text-2xl font-bold text-gray-900 mt-1">{{ \App\Models\Burial::count() }}</h2>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Pending Burial</p>
        <h2 class="text-2xl font-bold text-gray-900 mt-1">{{ \App\Models\Deceased::doesntHave('burial')->count() }}</h2>
    </div>
</div>

<!-- Table -->
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide">All Records</h2>
        <span class="text-xs text-gray-400">{{ $deceased->total() }} total</span>
    </div>
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Name</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Date of Birth</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Date of Death</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Cause of Death</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($deceased as $record)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        @if($record->photo)
                            <img src="{{ asset('storage/'.$record->photo) }}" class="w-9 h-9 rounded-full object-cover border border-gray-200">
                        @else
                            <div class="w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold text-gray-600">
                                {{ strtoupper(substr($record->first_name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <p class="text-sm font-semibold text-gray-900">{{ $record->first_name }} {{ $record->last_name }}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($record->date_of_birth)->format('M d, Y') }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($record->date_of_death)->format('M d, Y') }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $record->cause_of_death ?? 'N/A' }}</td>
                <td class="px-6 py-4">
                    @if($record->burial)
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Buried</span>
                    @else
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Pending</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">



                        <button onclick="openEditModal({{ $record->id }}, '{{ $record->first_name }}', '{{ $record->last_name }}', '{{ $record->date_of_birth }}', '{{ $record->date_of_death }}', '{{ $record->cause_of_death }}')" class="bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-blue-100 transition">Edit</button>
                        <button onclick="openDeleteModal({{ $record->id }})" class="bg-red-50 text-red-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-red-100 transition">Delete</button>

                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">No deceased records found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-gray-100">{{ $deceased->links() }}</div>
</div>


<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" style="display:none;">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-lg mx-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold text-gray-900">Edit Deceased Record</h2>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">First Name</label>
                    <input type="text" name="first_name" id="edit_first_name" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Last Name</label>
                    <input type="text" name="last_name" id="edit_last_name" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Date of Birth</label>
                    <input type="date" name="date_of_birth" id="edit_date_of_birth" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Date of Death</label>
                    <input type="date" name="date_of_death" id="edit_date_of_death" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Cause of Death</label>
                    <input type="text" name="cause_of_death" id="edit_cause_of_death" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Photo</label>
                    <input type="file" name="photo" accept="image/*" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm">
                </div>
            </div>
            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-gray-900 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">Save Changes</button>
                <button type="button" onclick="closeEditModal()" class="bg-gray-100 text-gray-800 px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-200 transition">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" style="display:none;">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md mx-4 text-center">
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>
        <h2 class="text-lg font-bold text-gray-900 mb-2">Delete Record</h2>
        <p class="text-gray-500 text-sm mb-6">Are you sure you want to delete this deceased record? This action cannot be undone.</p>
        <form id="deleteForm" method="POST">
            @csrf @method('DELETE')
            <div class="flex gap-3 justify-center">
                <button type="submit" class="bg-red-600 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-red-700 transition">Yes, Delete</button>
                <button type="button" onclick="closeDeleteModal()" class="bg-gray-100 text-gray-800 px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-200 transition">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, firstName, lastName, dob, dod, cause) {
    document.getElementById('edit_first_name').value = firstName;
    document.getElementById('edit_last_name').value = lastName;
    document.getElementById('edit_date_of_birth').value = dob;
    document.getElementById('edit_date_of_death').value = dod;
    document.getElementById('edit_cause_of_death').value = cause !== 'null' ? cause : '';
    document.getElementById('editForm').action = '/admin/deceased/' + id;
    document.getElementById('editModal').style.display = 'flex';
}

function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
}

function openDeleteModal(id) {
    document.getElementById('deleteForm').action = '/admin/deceased/' + id;
    document.getElementById('deleteModal').style.display = 'flex';
}

function closeDeleteModal() {
    document.getElementById('deleteModal').style.display = 'none';
}

window.onclick = function(e) {
    if (e.target.id === 'editModal') closeEditModal();
    if (e.target.id === 'deleteModal') closeDeleteModal();
}
</script>

@endsection
