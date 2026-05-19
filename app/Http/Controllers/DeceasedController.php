<?php

namespace App\Http\Controllers;

use App\Models\Deceased;
use Illuminate\Http\Request;

class DeceasedController extends Controller
{
    private function getPrefix()
    {
        return auth()->user()->isAdmin() ? 'admin' : 'staff';
    }

    private function getRoute()
    {
        return auth()->user()->isAdmin() ? 'admin' : 'staff';
    }

    public function index(Request $request)
    {
        // Live JS filter on the view handles searching while typing.
        // Keep server-side listing unfiltered by `search` query.
        $deceased = Deceased::latest()->paginate(10);

        return view($this->getPrefix().'.deceased.index', compact('deceased'));
    }



    public function create()
    {
        return view($this->getPrefix().'.deceased.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'date_of_death' => 'required|date',
            'cause_of_death' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        Deceased::create($data);

        return redirect()->route($this->getRoute().'.deceased.index')->with('success', 'Deceased record added successfully!');
    }

    public function show(Deceased $deceased)
    {
        return view($this->getPrefix().'.deceased.show', compact('deceased'));
    }

    public function edit(Deceased $deceased)
    {
        return view($this->getPrefix().'.deceased.edit', compact('deceased'));
    }

    public function update(Request $request, Deceased $deceased)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'date_of_death' => 'required|date',
            'cause_of_death' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $deceased->update($data);

        return redirect()->route($this->getRoute().'.deceased.index')->with('success', 'Deceased record updated successfully!');
    }

    public function destroy(Deceased $deceased)
    {
        $deceased->delete();
        return redirect()->route($this->getRoute().'.deceased.index')->with('success', 'Deceased record deleted successfully!');
    }


    // Public search endpoint (used by the public site)
    public function search(Request $request)
    {
        $query = $request->get('query');

        $deceased = Deceased::with(['burial.lot', 'families'])
            ->when($query, function ($q) use ($query) {
                $q->where('first_name', 'like', "%{$query}%")
                    ->orWhere('last_name', 'like', "%{$query}%");
            })
            ->latest()
            ->paginate(10);

        return view('public.search', compact('deceased', 'query'));
    }

}