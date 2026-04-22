@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">Edit Payment Record</h1>
</div>

<div class="bg-white rounded-xl shadow p-6 max-w-2xl">
    <form method="POST" action="{{ route('admin.payments.update', $payment) }}">
        @csrf @method('PUT')
        <div class="grid grid-cols-2 gap-4">
            <div class="col-span-2">
                <label class="block text-gray-700 font-semibold mb-1">Burial (Deceased)</label>
                <select name="burial_id" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                    <option value="">-- Select Burial --</option>
                    @foreach($burials as $burial)
                        <option value="{{ $burial->id }}" {{ old('burial_id', $payment->burial_id) == $burial->id ? 'selected' : '' }}>
                            {{ $burial->deceased->first_name }} {{ $burial->deceased->last_name }} — {{ $burial->burial_date }}
                        </option>
                    @endforeach
                </select>
                @error('burial_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Amount (₱)</label>
                <input type="number" step="0.01" name="amount" value="{{ old('amount', $payment->amount) }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                @error('amount')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Payment Date</label>
                <input type="date" name="payment_date" value="{{ old('payment_date', $payment->payment_date) }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400">
                @error('payment_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Type</label>
                <select name="type" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                    <option value="">-- Select Type --</option>
                    <option value="burial_fee" {{ old('type', $payment->type) == 'burial_fee' ? 'selected' : '' }}>Burial Fee</option>
                    <option value="maintenance_fee" {{ old('type', $payment->type) == 'maintenance_fee' ? 'selected' : '' }}>Maintenance Fee</option>
                    <option value="other" {{ old('type', $payment->type) == 'other' ? 'selected' : '' }}>Other</option>
                </select>
                @error('type')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Status</label>
                <select name="status" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400" required>
                    <option value="">-- Select Status --</option>
                    <option value="paid" {{ old('status', $payment->status) == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="unpaid" {{ old('status', $payment->status) == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    <option value="partial" {{ old('status', $payment->status) == 'partial' ? 'selected' : '' }}>Partial</option>
                </select>
                @error('status')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="col-span-2">
                <label class="block text-gray-700 font-semibold mb-1">Notes</label>
                <textarea name="notes" rows="3" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-gray-400">{{ old('notes', $payment->notes) }}</textarea>
                @error('notes')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="mt-6 flex gap-3">
            <button type="submit" class="bg-gray-900 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition">Update Record</button>
            <a href="{{ route('admin.payments.index') }}" class="bg-gray-200 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-300 transition">Cancel</a>
        </div>
    </form>
</div>
@endsection