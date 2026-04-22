<?php

namespace App\Http\Controllers;

use App\Models\Lot;
use Illuminate\Http\Request;

class LotController extends Controller
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
        $lots = Lot::latest()->paginate(10);
        return view($this->getPrefix().'.lots.index', compact('lots'));
    }

    public function create()
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('staff.lots.index')->with('error', 'Access denied. Admins only.');
        }
        return view('admin.lots.create');
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('staff.lots.index')->with('error', 'Access denied. Admins only.');
        }

        $request->validate([
            'lot_number' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'row' => 'required|string|max:255',
            'type' => 'required|in:ground,mausoleum,columbarium',
            'status' => 'required|in:available,occupied,reserved',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        Lot::create($request->all());

        return redirect()->route('admin.lots.index')->with('success', 'Lot added successfully!');
    }

    public function show(Lot $lot)
    {
        return view($this->getPrefix().'.lots.show', compact('lot'));
    }

    public function edit(Lot $lot)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('staff.lots.index')->with('error', 'Access denied. Admins only.');
        }
        return view('admin.lots.edit', compact('lot'));
    }

    public function update(Request $request, Lot $lot)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('staff.lots.index')->with('error', 'Access denied. Admins only.');
        }

        $request->validate([
            'lot_number' => 'required|string|max:255',
            'section' => 'required|string|max:255',
            'row' => 'required|string|max:255',
            'type' => 'required|in:ground,mausoleum,columbarium',
            'status' => 'required|in:available,occupied,reserved',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $lot->update($request->all());

        return redirect()->route('admin.lots.index')->with('success', 'Lot updated successfully!');
    }

    public function destroy(Lot $lot)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('staff.lots.index')->with('error', 'Access denied. Admins only.');
        }
        $lot->delete();
        return redirect()->route('admin.lots.index')->with('success', 'Lot deleted successfully!');
    }

    public function publicIndex()
    {
        $lots = Lot::where('status', 'available')->paginate(10);
        return view('public.lots', compact('lots'));
    }
}