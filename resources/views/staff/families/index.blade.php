@extends('layouts.staff')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Family Records</h1>
        <p class="text-gray-500 text-sm mt-1">Manage next of kin and family contact information.</p>
    </div>
    <a href="{{ route('staff.families.create') }}" class="bg-gray-900 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">Add Family</a>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Total Family Records</p>
        <h2 class="text-2xl font-bold text-gray-900 mt-1">{{ $families->total() }}</h2>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Linked Deceased</p>
        <h2 class="text-2xl font-bold text-gray-900 mt-1">{{ \App\Models\Family::distinct('deceased_id')->count() }}</h2>
    </div>
</div>

<!-- Table -->
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide">All Family Records</h2>
        <span class="text-xs text-gray-400">{{ $families->total() }} total</span>
    </div>
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Name</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Relationship</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Contact Number</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Linked Deceased</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($families as $family)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4">
                    <p class="text-sm font-semibold text-gray-900">{{ $family->first_name }} {{ $family->last_name }}</p>
                    @if($family->email)
                        <p class="text-xs text-gray-400 mt-0.5">{{ $family->email }}</p>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold">{{ $family->relationship }}</span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $family->contact_number }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $family->deceased->first_name }} {{ $family->deceased->last_name }}</td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">

                        <button
                            type="button"
                            onclick="openFamilyEditModal({{ $family->id }}, '{{ $family->first_name }}', '{{ $family->last_name }}', '{{ $family->contact_number }}', '{{ $family->email }}', '{{ $family->relationship }}', '{{ $family->deceased_id }}')"
                            class="bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-blue-100 transition">Edit</button>

                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-400">No family records found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-gray-100">{{ $families->links() }}</div>
</div>
<!-- Family Edit Modal -->
<div id="familyEditModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" style="display:none;">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-lg mx-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold text-gray-900">Edit Family Record</h2>
            <button type="button" onclick="closeFamilyEditModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>

        <form id="familyEditForm" method="POST" action="" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">First Name</label>
                    <input type="text" name="first_name" id="family_edit_first_name" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Last Name</label>
                    <input type="text" name="last_name" id="family_edit_last_name" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Contact Number</label>
                    <input type="text" name="contact_number" id="family_edit_contact_number" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="family_edit_email" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Relationship</label>
                    <input type="text" name="relationship" id="family_edit_relationship" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Linked Deceased ID</label>
                    <input type="number" name="deceased_id" id="family_edit_deceased_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-gray-900 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">Save Changes</button>
                <button type="button" onclick="closeFamilyEditModal()" class="bg-gray-100 text-gray-800 px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-200 transition">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openFamilyEditModal(id, firstName, lastName, contactNumber, email, relationship, deceasedId) {
        document.getElementById('family_edit_first_name').value = firstName || '';
        document.getElementById('family_edit_last_name').value = lastName || '';
        document.getElementById('family_edit_contact_number').value = contactNumber || '';
        document.getElementById('family_edit_email').value = email || '';
        document.getElementById('family_edit_relationship').value = relationship || '';
        document.getElementById('family_edit_deceased_id').value = deceasedId || '';

        document.getElementById('familyEditForm').action = '/staff/families/' + id;

        const modal = document.getElementById('familyEditModal');
        modal.style.display = 'flex';
        modal.classList.remove('hidden');
    }

    function closeFamilyEditModal() {
        const modal = document.getElementById('familyEditModal');
        modal.style.display = 'none';
        modal.classList.add('hidden');
    }

    window.onclick = function(e) {
        if (e.target.id === 'familyEditModal') closeFamilyEditModal();
    };
</script>

@endsection
