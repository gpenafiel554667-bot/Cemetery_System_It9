@extends('layouts.staff')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Burial Records</h1>
        <p class="text-gray-500 text-sm mt-1">Manage all burial records in the system.</p>
    </div>
    <a href="{{ route('staff.burials.create') }}" class="bg-gray-900 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">Add Burial</a>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Total Burials</p>
        <h2 class="text-2xl font-bold text-gray-900 mt-1">{{ $burials->total() }}</h2>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-gray-500 text-xs uppercase tracking-wide">This Month</p>
        <h2 class="text-2xl font-bold text-gray-900 mt-1">{{ \App\Models\Burial::whereMonth('burial_date', now()->month)->whereYear('burial_date', now()->year)->count() }}</h2>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-gray-500 text-xs uppercase tracking-wide">This Year</p>
        <h2 class="text-2xl font-bold text-gray-900 mt-1">{{ \App\Models\Burial::whereYear('burial_date', now()->year)->count() }}</h2>
    </div>
</div>

<!-- Table -->
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide">All Burials</h2>
        <span class="text-xs text-gray-400">{{ $burials->total() }} total</span>
    </div>
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Deceased</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Lot</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Burial Date</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Type</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($burials as $burial)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $burial->deceased->first_name }} {{ $burial->deceased->last_name }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">Lot {{ $burial->lot->lot_number }}, Section {{ $burial->lot->section }}, Row {{ $burial->lot->row }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($burial->burial_date)->format('M d, Y') }}</td>
                <td class="px-6 py-4 text-sm text-gray-600 capitalize">{{ $burial->burial_type }}</td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">

                        <button
                            type="button"
                            onclick="openBurialEditModal({{ $burial->id }}, '{{ $burial->burial_type }}', '{{ $burial->burial_date }}', '{{ $burial->lot_id }}')"
                            class="bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-blue-100 transition">Edit</button>

                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-400">No burial records found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-gray-100">{{ $burials->links() }}</div>
</div>
<!-- Burial Edit Modal -->
<div id="burialEditModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" style="display:none;">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-lg mx-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold text-gray-900">Edit Burial Record</h2>
            <button type="button" onclick="closeBurialEditModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>

        <form id="burialEditForm" method="POST" action="" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Burial Date</label>
                    <input type="date" name="burial_date" id="edit_burial_date" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Burial Type</label>
                    <input type="text" name="burial_type" id="edit_burial_type" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Lot ID</label>
                    <input type="number" name="lot_id" id="edit_lot_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-gray-900 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">Save Changes</button>
                <button type="button" onclick="closeBurialEditModal()" class="bg-gray-100 text-gray-800 px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-200 transition">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openBurialEditModal(id, burialType, burialDate, lotId) {
        document.getElementById('edit_burial_type').value = burialType || '';
        document.getElementById('edit_burial_date').value = burialDate || '';
        document.getElementById('edit_lot_id').value = lotId || '';

        document.getElementById('burialEditForm').action = '/staff/burials/' + id;

        const modal = document.getElementById('burialEditModal');
        modal.style.display = 'flex';
        modal.classList.remove('hidden');
    }

    function closeBurialEditModal() {
        const modal = document.getElementById('burialEditModal');
        modal.style.display = 'none';
        modal.classList.add('hidden');
    }

    window.onclick = function(e) {
        if (e.target.id === 'burialEditModal') closeBurialEditModal();
    };
</script>

@endsection
