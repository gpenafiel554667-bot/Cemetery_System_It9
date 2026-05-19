@extends('layouts.admin')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Payment Records</h1>
        <p class="text-gray-500 text-sm mt-1">Manage all burial and maintenance payment records.</p>
    </div>
    <a href="{{ route('admin.payments.create') }}" class="bg-gray-900 text-white px-5 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">Add Payment</a>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Total Collections</p>
        <h2 class="text-2xl font-bold text-gray-900 mt-1">PHP {{ number_format(\App\Models\Payment::sum('amount'), 2) }}</h2>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Paid</p>
        <h2 class="text-2xl font-bold text-green-600 mt-1">PHP {{ number_format(\App\Models\Payment::where('status','paid')->sum('amount'), 2) }}</h2>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <p class="text-gray-500 text-xs uppercase tracking-wide">Unpaid</p>
        <h2 class="text-2xl font-bold text-red-600 mt-1">PHP {{ number_format(\App\Models\Payment::where('status','unpaid')->sum('amount'), 2) }}</h2>
    </div>
</div>

<!-- Table -->
<div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-sm font-bold text-gray-900 uppercase tracking-wide">All Payments</h2>
        <span class="text-xs text-gray-400">{{ $payments->total() }} total</span>
    </div>
    <table class="w-full">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Deceased</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Type</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Amount</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Date</th>
                <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($payments as $payment)
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $payment->burial->deceased->first_name }} {{ $payment->burial->deceased->last_name }}</td>
                <td class="px-6 py-4 text-sm text-gray-600 capitalize">{{ str_replace('_', ' ', $payment->type) }}</td>
                <td class="px-6 py-4 text-sm font-semibold text-gray-900">PHP {{ number_format($payment->amount, 2) }}</td>
                <td class="px-6 py-4">
                    @if($payment->status === 'paid')
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Paid</span>
                    @elseif($payment->status === 'unpaid')
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">Unpaid</span>
                    @else
                        <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Partial</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">{{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('M d, Y') : 'N/A' }}</td>
                <td class="px-6 py-4">
                    <div class="flex gap-2">

<button type="button" onclick="openEditPaymentModal({{ $payment->id }}, @js($payment->type), @js($payment->amount), @js($payment->status), @js(optional($payment->payment_date)->format('Y-m-d')))" class="bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-blue-100 transition">Edit</button>

                        <button onclick="openDeletePaymentModal({{ $payment->id }})" class="bg-red-50 text-red-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-red-100 transition">Delete</button>


                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">No payment records found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-gray-100">{{ $payments->links() }}</div>
</div>


<!-- Edit Payment Modal -->
<div id="editPaymentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" style="display:none;">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-lg mx-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-bold text-gray-900">Edit Payment</h2>
            <button onclick="closeEditPaymentModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>
        <form id="editPaymentForm" method="POST">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Type</label>
                    <select name="type" id="edit_payment_type" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                        <option value="burial_fee">Burial Fee</option>
                        <option value="maintenance_fee">Maintenance Fee</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Amount</label>
                    <input type="number" step="0.01" name="amount" id="edit_payment_amount" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Status</label>
                    <select name="status" id="edit_payment_status" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                        <option value="paid">Paid</option>
                        <option value="unpaid">Unpaid</option>
                        <option value="partial">Partial</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Payment Date</label>
                    <input type="date" name="payment_date" id="edit_payment_date" class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-400">
                </div>
            </div>
            <div class="mt-6 flex gap-3">
                <button type="submit" class="bg-gray-900 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-700 transition">Save Changes</button>
                <button type="button" onclick="closeEditPaymentModal()" class="bg-gray-100 text-gray-800 px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-200 transition">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Payment Modal -->
<div id="deletePaymentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" style="display:none;">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md mx-4 text-center">
        <h2 class="text-lg font-bold text-gray-900 mb-2">Delete Payment</h2>
        <p class="text-gray-500 text-sm mb-6">Are you sure you want to delete this payment record? This action cannot be undone.</p>
        <form id="deletePaymentForm" method="POST">
            @csrf @method('DELETE')
            <div class="flex gap-3 justify-center">
                <button type="submit" class="bg-red-600 text-white px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-red-700 transition">Yes, Delete</button>
                <button type="button" onclick="closeDeletePaymentModal()" class="bg-gray-100 text-gray-800 px-6 py-2.5 rounded-lg text-sm font-semibold hover:bg-gray-200 transition">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditPaymentModal(id, type, amount, status, paymentDate) {
    var modal = document.getElementById('editPaymentModal');
    if (modal) {
        modal.style.display = 'flex';
        modal.classList.remove('hidden');
    }

    var form = document.getElementById('editPaymentForm');
    if (form) {
        form.action = '/admin/payments/' + id;
    }

    var typeInput = document.getElementById('edit_payment_type');
    var amountInput = document.getElementById('edit_payment_amount');
    var statusInput = document.getElementById('edit_payment_status');
    var dateInput = document.getElementById('edit_payment_date');

    if (typeInput) typeInput.value = type || '';
    if (amountInput) amountInput.value = amount || '';
    if (statusInput) statusInput.value = status || 'paid';
    if (dateInput) dateInput.value = paymentDate || '';
}

function closeEditPaymentModal() {
    var modal = document.getElementById('editPaymentModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

function openDeletePaymentModal(id) {

    var form = document.getElementById('deletePaymentForm');
    if (form) {
        form.action = '/admin/payments/' + id;
    }

    var modal = document.getElementById('deletePaymentModal');
    if (modal) {
        modal.style.display = 'flex';
        modal.classList.remove('hidden');
    }
}


function closeDeletePaymentModal() {
    var modal = document.getElementById('deletePaymentModal');
    if (modal) modal.style.display = 'none';
}


window.onclick = function(e) {
    if (e.target.id === 'deletePaymentModal') closeDeletePaymentModal();
}
</script>

@endsection
