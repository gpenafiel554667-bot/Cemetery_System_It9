@extends('layouts.staff')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Deceased Records</h1>
        <p class="text-gray-500 text-sm mt-1">Manage all deceased records in the system.</p>
    </div>
    <a href="{{ route('staff.deceased.create') }}" class="bg-gray-900 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">Add Record</a>
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
                        <p class="text-sm font-semibold text-gray-900">{{ $record->first_name }} {{ $record->last_name }}</p>
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
                        <button
                            type="button"
                            onclick="openEditModal({{ $record->id }}, '{{ $record->first_name }}', '{{ $record->last_name }}', '{{ $record->date_of_birth }}', '{{ $record->date_of_death }}', '{{ $record->cause_of_death }}')"
                            class="bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-blue-100 transition">
                            Edit
                        </button>
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
            <button type="button" onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>

        <form id="editForm" method="POST" action="" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">First Name</label>
                    <input type="text" name="first_name" id="edit_first_name" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Last Name</label>
                    <input type="text" name="last_name" id="edit_last_name" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Date of Birth</label>
                    <input type="date" name="date_of_birth" id="edit_date_of_birth" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Date of Death</label>
                    <input type="date" name="date_of_death" id="edit_date_of_death" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Cause of Death</label>
                    <input type="text" name="cause_of_death" id="edit_cause_of_death" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
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

<script>
    function openEditModal(id, firstName, lastName, dob, dod, cause) {
        document.getElementById('edit_first_name').value = firstName || '';
        document.getElementById('edit_last_name').value = lastName || '';
        document.getElementById('edit_date_of_birth').value = dob || '';
        document.getElementById('edit_date_of_death').value = dod || '';
        document.getElementById('edit_cause_of_death').value = (cause && cause !== 'null') ? cause : '';

        document.getElementById('editForm').action = '/staff/deceased/' + id;

        const modal = document.getElementById('editModal');
        modal.style.display = 'flex';
        modal.classList.remove('hidden');
    }

    function closeEditModal() {
        const modal = document.getElementById('editModal');
        modal.style.display = 'none';
        modal.classList.add('hidden');
    }

    window.onclick = function(e) {
        if (e.target.id === 'editModal') closeEditModal();
    };
</script>

@endsection
