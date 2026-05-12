@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Lots & Plots</h1>
        <p class="text-gray-500 text-sm mt-1">Manage all cemetery lots and plots.</p>
    </div>
    <a href="{{ route('admin.lots.create') }}" class="bg-gray-900 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">Add Lot</a>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Available</p>
        <h2 class="text-2xl font-bold text-green-600 mt-1">{{ \App\Models\Lot::where('status','available')->count() }}</h2>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Occupied</p>
        <h2 class="text-2xl font-bold text-red-600 mt-1">{{ \App\Models\Lot::where('status','occupied')->count() }}</h2>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Reserved</p>
        <h2 class="text-2xl font-bold text-yellow-600 mt-1">{{ \App\Models\Lot::where('status','reserved')->count() }}</h2>
    </div>
</div>

<!-- Table -->
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide">All Lots</h2>
        <span class="text-xs text-gray-400">{{ $lots->total() }} total</span>
    </div>
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Lot Number</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Section</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Row</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Type</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Price</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($lots as $lot)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $lot->lot_number }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $lot->section }}</td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $lot->row }}</td>
                <td class="px-6 py-4 text-sm text-gray-600 capitalize">{{ $lot->type }}</td>
                <td class="px-6 py-4">
                    @if($lot->status === 'available')
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Available</span>
                    @elseif($lot->status === 'occupied')
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">Occupied</span>
                    @else
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Reserved</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm font-semibold text-gray-900">PHP {{ number_format($lot->price, 2) }}</td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">



                        <button onclick="openEditLotModal({{ $lot->id }}, '{{ $lot->lot_number }}', '{{ $lot->section }}', '{{ $lot->row }}', '{{ $lot->type }}', '{{ $lot->status }}', '{{ $lot->price }}')" class="bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-blue-100 transition">Edit</button>
                        <button onclick="openDeleteLotModal({{ $lot->id }})" class="bg-red-50 text-red-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-red-100 transition">Delete</button>

                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-400">No lots found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-gray-100">{{ $lots->links() }}</div>
</div>


<!-- Edit Lot Modal -->
<div id="editLotModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" style="display:none;">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-lg mx-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold text-gray-900">Edit Lot</h2>
            <button onclick="closeEditLotModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>
        <form id="editLotForm" method="POST">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Lot Number</label>
                    <input type="text" name="lot_number" id="edit_lot_number" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Section</label>
                    <input type="text" name="section" id="edit_lot_section" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Row</label>
                    <input type="text" name="row" id="edit_lot_row" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Type</label>
                    <input type="text" name="type" id="edit_lot_type" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                    <select name="status" id="edit_lot_status" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                        <option value="available">Available</option>
                        <option value="occupied">Occupied</option>
                        <option value="reserved">Reserved</option>
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Price</label>
                    <input type="number" step="0.01" name="price" id="edit_lot_price" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                </div>
            </div>
            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-gray-900 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">Save Changes</button>
                <button type="button" onclick="closeEditLotModal()" class="bg-gray-100 text-gray-800 px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-200 transition">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Lot Modal -->
<div id="deleteLotModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" style="display:none;">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md mx-4 text-center">
        <h2 class="text-lg font-bold text-gray-900 mb-2">Delete Lot</h2>
        <p class="text-gray-500 text-sm mb-6">Are you sure you want to delete this lot? This action cannot be undone.</p>
        <form id="deleteLotForm" method="POST">
            @csrf @method('DELETE')
            <div class="flex gap-3 justify-center">
                <button type="submit" class="bg-red-600 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-red-700 transition">Yes, Delete</button>
                <button type="button" onclick="closeDeleteLotModal()" class="bg-gray-100 text-gray-800 px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-200 transition">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditLotModal(id, lotNumber, section, row, type, status, price) {
    document.getElementById('edit_lot_number').value = lotNumber;
    document.getElementById('edit_lot_section').value = section;
    document.getElementById('edit_lot_row').value = row;
    document.getElementById('edit_lot_type').value = type;
    document.getElementById('edit_lot_status').value = status;
    document.getElementById('edit_lot_price').value = price;
    document.getElementById('editLotForm').action = '/admin/lots/' + id;
    document.getElementById('editLotModal').style.display = 'flex';
}

function closeEditLotModal() {
    document.getElementById('editLotModal').style.display = 'none';
}

function openDeleteLotModal(id) {
    document.getElementById('deleteLotForm').action = '/admin/lots/' + id;
    document.getElementById('deleteLotModal').style.display = 'flex';
}

function closeDeleteLotModal() {
    document.getElementById('deleteLotModal').style.display = 'none';
}

window.onclick = function(e) {
    if (e.target.id === 'editLotModal') closeEditLotModal();
    if (e.target.id === 'deleteLotModal') closeDeleteLotModal();
}
</script>

@endsection
