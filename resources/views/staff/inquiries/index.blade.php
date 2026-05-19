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
                        onclick="openInquiryModal({
                            id: {{ $inquiry->id }},
                            name: @js($inquiry->name),
                            email: @js($inquiry->email),
                            contact: @js($inquiry->contact_number),
                            message: @js($inquiry->message),
                            status: @js($inquiry->status),
                            response: @js($inquiry->response),
                            createdAt: @js($inquiry->created_at->format('M d, Y h:i A')),
                            respondedAt: @js($inquiry->responded_at?->format('M d, Y h:i A'))
                        })"
                        class="bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-semibold hover:bg-blue-100 transition">Manage</button>
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

<!-- Inquiry Manage Modal -->
<div id="inquiryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" style="display:none;">
    <div class="bg-white rounded-2xl shadow-2xl p-6 w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-start mb-5">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Manage Inquiry</h2>
                <p id="modal_created_at" class="text-xs text-gray-400 mt-1"></p>
            </div>
            <button type="button" onclick="closeInquiryModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-5">
            <div>
                <p class="text-gray-500 text-sm">Name</p>
                <p id="modal_name" class="font-semibold text-gray-800"></p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Contact</p>
                <p id="modal_contact" class="font-semibold text-gray-800"></p>
            </div>
            <div class="col-span-2">
                <p class="text-gray-500 text-sm">Email</p>
                <p id="modal_email" class="font-semibold text-gray-800"></p>
            </div>
            <div class="col-span-2">
                <p class="text-gray-500 text-sm">Message</p>
                <p id="modal_message" class="font-semibold text-gray-800 whitespace-pre-line mt-1"></p>
            </div>
            <div id="modal_responded_wrap" class="hidden">
                <p class="text-gray-500 text-sm">Responded At</p>
                <p id="modal_responded_at" class="font-semibold text-gray-800"></p>
            </div>
        </div>

        <form id="inquiryUpdateForm" method="POST" class="border-t border-gray-100 pt-5">
            @csrf @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Status</label>
                    <select name="status" id="modal_status" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="pending">Pending</option>
                        <option value="read">Read</option>
                        <option value="responded">Responded</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Reply Notes</label>
                    <textarea name="response" id="modal_response" rows="5" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Type the response or action taken here..."></textarea>
                </div>
                <div class="flex flex-wrap gap-3 justify-between">
                    <div class="flex gap-3">
                        <button type="submit" class="bg-blue-900 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Save</button>
                        <button type="button" onclick="closeInquiryModal()" class="bg-gray-100 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-200 transition">Cancel</button>
                    </div>
                    <button type="button" onclick="submitInquiryDelete()" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">Delete</button>
                </div>
            </div>
        </form>

        <form id="inquiryDeleteForm" method="POST" class="hidden">
            @csrf @method('DELETE')
        </form>
    </div>
</div>

<script>
function openInquiryModal(inquiry) {
    document.getElementById('modal_name').textContent = inquiry.name || 'N/A';
    document.getElementById('modal_contact').textContent = inquiry.contact || 'N/A';
    document.getElementById('modal_email').textContent = inquiry.email || 'N/A';
    document.getElementById('modal_message').textContent = inquiry.message || '';
    document.getElementById('modal_created_at').textContent = inquiry.createdAt ? 'Submitted ' + inquiry.createdAt : '';
    document.getElementById('modal_status').value = inquiry.status || 'pending';
    document.getElementById('modal_response').value = inquiry.response || '';

    const respondedWrap = document.getElementById('modal_responded_wrap');
    document.getElementById('modal_responded_at').textContent = inquiry.respondedAt || '';
    respondedWrap.classList.toggle('hidden', !inquiry.respondedAt);

    document.getElementById('inquiryUpdateForm').action = '/staff/inquiries/' + inquiry.id;
    document.getElementById('inquiryDeleteForm').action = '/staff/inquiries/' + inquiry.id;

    const modal = document.getElementById('inquiryModal');
    modal.style.display = 'flex';
    modal.classList.remove('hidden');
}

function closeInquiryModal() {
    const modal = document.getElementById('inquiryModal');
    modal.style.display = 'none';
    modal.classList.add('hidden');
}

function submitInquiryDelete() {
    if (confirm('Delete this inquiry? This action cannot be undone.')) {
        document.getElementById('inquiryDeleteForm').submit();
    }
}

window.addEventListener('click', function(e) {
    if (e.target && e.target.id === 'inquiryModal') closeInquiryModal();
});
</script>

@endsection
