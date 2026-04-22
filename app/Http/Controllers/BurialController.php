<?php

namespace App\Http\Controllers;

use App\Models\Burial;
use App\Models\Deceased;
use App\Models\Lot;
use Illuminate\Http\Request;

class BurialController extends Controller
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
        $burials = Burial::with(['deceased', 'lot'])->latest()->paginate(10);
        return view($this->getPrefix().'.burials.index', compact('burials'));
    }

    public function create()
{
    // Only show deceased that don't have a burial yet
    $deceased = Deceased::whereDoesntHave('burial')->get();

    // Only show available lots with info of who's in occupied ones
    $lots = Lot::where('status', 'available')->get();

    return view($this->getPrefix().'.burials.create', compact('deceased', 'lots'));
}

    public function store(Request $request)
    {
        $request->validate([
            'deceased_id' => 'required|exists:deceaseds,id',
            'lot_id' => 'required|exists:lots,id',
            'burial_date' => 'required|date',
            'burial_type' => 'required|in:ground,mausoleum,columbarium',
            'notes' => 'nullable|string',
        ]);

        Burial::create($request->all());

        Lot::find($request->lot_id)->update(['status' => 'occupied']);

        return redirect()->route($this->getRoute().'.burials.index')->with('success', 'Burial record added successfully!');
    }

    public function show(Burial $burial)
    {
        $burial->load(['deceased', 'lot', 'payments']);
        return view($this->getPrefix().'.burials.show', compact('burial'));
    }

    public function edit(Burial $burial)
    {
        $deceased = Deceased::all();
        $lots = Lot::all();
        return view($this->getPrefix().'.burials.edit', compact('burial', 'deceased', 'lots'));
    }

    public function update(Request $request, Burial $burial)
    {
        $request->validate([
            'deceased_id' => 'required|exists:deceaseds,id',
            'lot_id' => 'required|exists:lots,id',
            'burial_date' => 'required|date',
            'burial_type' => 'required|in:ground,mausoleum,columbarium',
            'notes' => 'nullable|string',
        ]);

        $burial->update($request->all());

        return redirect()->route($this->getRoute().'.burials.index')->with('success', 'Burial record updated successfully!');
    }

    public function destroy(Burial $burial)
    {
        Lot::find($burial->lot_id)->update(['status' => 'available']);
        $burial->delete();
        return redirect()->route($this->getRoute().'.burials.index')->with('success', 'Burial record deleted successfully!');
    }
}