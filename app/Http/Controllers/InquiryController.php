<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
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
        $inquiries = Inquiry::latest()->paginate(10);
        return view($this->getPrefix().'.inquiries.index', compact('inquiries'));
    }

    public function create()
    {
        return view($this->getPrefix().'.inquiries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'contact_number' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Inquiry::create($validated);

        return redirect()->route('home')->with('success', 'Inquiry sent successfully! We will contact you soon.');
    }

    public function show(Inquiry $inquiry)
    {
        if ($inquiry->status === 'pending') {
            $inquiry->update(['status' => 'read']);
        }
        return view($this->getPrefix().'.inquiries.show', compact('inquiry'));
    }

    public function edit(Inquiry $inquiry)
    {
        return view($this->getPrefix().'.inquiries.edit', compact('inquiry'));
    }

    public function update(Request $request, Inquiry $inquiry)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,read,responded',
            'response' => 'nullable|string',
        ]);

        if (filled($validated['response'] ?? null)) {
            $validated['status'] = 'responded';
            $validated['responded_at'] = now();
        } elseif (($validated['status'] ?? null) !== 'responded') {
            $validated['responded_at'] = null;
        }

        $inquiry->update($validated);

        return redirect()->route($this->getRoute().'.inquiries.index')->with('success', 'Inquiry updated successfully!');
    }

    public function destroy(Inquiry $inquiry)
    {
        $inquiry->delete();
        return redirect()->route($this->getRoute().'.inquiries.index')->with('success', 'Inquiry deleted successfully!');
    }
}
