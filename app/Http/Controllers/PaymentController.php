<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Burial;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private function getPrefix()
    {
        return auth()->user()->isAdmin() ? 'admin' : 'staff';
    }

    private function getRoute()
    {
        return auth()->user()->isAdmin() ? 'admin' : 'staff';
    }

    public function index()
    {
        $payments = Payment::with('burial.deceased')->latest()->paginate(10);
        return view($this->getPrefix().'.payments.index', compact('payments'));
    }

    public function create()
    {
        $burials = Burial::with(['deceased', 'lot'])->get();
        return view($this->getPrefix().'.payments.create', compact('burials'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'burial_id' => 'required|exists:burials,id',
            'type' => 'required|in:burial_fee,maintenance_fee,other',
            'status' => 'required|in:paid,unpaid,partial',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $validated['amount'] = Burial::with('lot')->findOrFail($validated['burial_id'])->lot->price;

        Payment::create($validated);

        return redirect()->route($this->getRoute().'.payments.index')->with('success', 'Payment recorded successfully!');
    }

    public function show(Payment $payment)
    {
        $payment->load('burial.deceased');
        return view($this->getPrefix().'.payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $burials = Burial::with(['deceased', 'lot'])->get();
        return view($this->getPrefix().'.payments.edit', compact('payment', 'burials'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'burial_id' => 'sometimes|required|exists:burials,id',
            'type' => 'required|in:burial_fee,maintenance_fee,other',
            'status' => 'required|in:paid,unpaid,partial',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $burialId = $validated['burial_id'] ?? $payment->burial_id;
        $validated['amount'] = Burial::with('lot')->findOrFail($burialId)->lot->price;

        $payment->update($validated);

        return redirect()->route($this->getRoute().'.payments.index')->with('success', 'Payment updated successfully!');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route($this->getRoute().'.payments.index')->with('success', 'Payment deleted successfully!');
    }
}
