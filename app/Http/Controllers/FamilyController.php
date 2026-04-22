<?php

namespace App\Http\Controllers;

use App\Models\Family;
use App\Models\Deceased;
use Illuminate\Http\Request;

class FamilyController extends Controller
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
        $families = Family::with('deceased')->latest()->paginate(10);
        return view($this->getPrefix().'.families.index', compact('families'));
    }

    public function create()
    {
        $deceased = Deceased::all();
        return view($this->getPrefix().'.families.create', compact('deceased'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'deceased_id' => 'required|exists:deceaseds,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'relationship' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
        ]);

        Family::create($request->all());

        return redirect()->route($this->getRoute().'.families.index')->with('success', 'Family record added successfully!');
    }

    public function show(Family $family)
    {
        $family->load('deceased');
        return view($this->getPrefix().'.families.show', compact('family'));
    }

    public function edit(Family $family)
    {
        $deceased = Deceased::all();
        return view($this->getPrefix().'.families.edit', compact('family', 'deceased'));
    }

    public function update(Request $request, Family $family)
    {
        $request->validate([
            'deceased_id' => 'required|exists:deceaseds,id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'relationship' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
        ]);

        $family->update($request->all());

        return redirect()->route($this->getRoute().'.families.index')->with('success', 'Family record updated successfully!');
    }

    public function destroy(Family $family)
    {
        $family->delete();
        return redirect()->route($this->getRoute().'.families.index')->with('success', 'Family record deleted successfully!');
    }
}