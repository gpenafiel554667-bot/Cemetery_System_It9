<?php

namespace App\Http\Controllers;

use App\Models\ProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileRequestController extends Controller
{
    // Admin - view own profile
    public function adminProfile()
    {
        return view('admin.profile', ['user' => auth()->user()]);
    }

    // Admin - update own profile directly (split by form_type)
    public function adminUpdate(Request $request)
    {
        $user = auth()->user();

        if ($request->form_type === 'password') {
            $request->validate([
                'password' => 'required|min:6|confirmed',
            ]);

            $user->update([
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('admin.profile')->with('success', 'Password updated successfully.');
        }

        // form_type === 'info' (name, email, photo)
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
        ];

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('profiles', 'public');
        }

        $user->update($data);

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully.');
    }

    // Staff - view own profile
    public function staffProfile()
    {
        $pendingRequest = ProfileRequest::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->latest()
            ->first();

        $requests = ProfileRequest::where('user_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();

        return view('staff.profile', compact('pendingRequest', 'requests'));
    }

    // Staff - submit profile change request
    public function staffRequest(Request $request)
    {
        $rules = [
            'requested_name'  => 'nullable|string|max:255',
            'requested_email' => 'nullable|email',
            'requested_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];

        // Only enforce password confirmation if a password was actually typed
        if ($request->filled('requested_password')) {
            $rules['requested_password'] = 'min:6|confirmed:requested_password_confirmation';
        }

        $request->validate($rules);

        // Must have at least one field filled
        if (
            !$request->filled('requested_name') &&
            !$request->filled('requested_email') &&
            !$request->filled('requested_password') &&
            !$request->hasFile('requested_photo')
        ) {
            return redirect()->route('staff.profile')->with('error', 'Please fill in at least one field to submit a request.');
        }

        // Check if there's already a pending request
        $existing = ProfileRequest::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return redirect()->route('staff.profile')->with('error', 'You already have a pending request. Please wait for admin approval.');
        }

        $data = [
            'user_id'            => auth()->id(),
            'requested_name'     => $request->requested_name ?: null,
            'requested_email'    => $request->requested_email ?: null,
            'requested_password' => $request->filled('requested_password') ? Hash::make($request->requested_password) : null,
        ];

        if ($request->hasFile('requested_photo')) {
            $data['requested_photo'] = $request->file('requested_photo')->store('profiles', 'public');
        }

        ProfileRequest::create($data);

        return redirect()->route('staff.profile')->with('success', 'Profile change request submitted. Waiting for admin approval.');
    }

    // Admin - view all profile requests
    public function adminRequests()
    {
        $requests = ProfileRequest::with('user')->latest()->paginate(10);
        return view('admin.profile-requests', compact('requests'));
    }

    // Admin - approve request
    public function approve(ProfileRequest $profileRequest)
    {
        $user = $profileRequest->user;

        $data = [];

        if ($profileRequest->requested_name)     $data['name']     = $profileRequest->requested_name;
        if ($profileRequest->requested_email)    $data['email']    = $profileRequest->requested_email;
        if ($profileRequest->requested_password) $data['password'] = $profileRequest->requested_password;
        if ($profileRequest->requested_photo)    $data['photo']    = $profileRequest->requested_photo;

        $user->update($data);
        $profileRequest->update(['status' => 'approved']);

        return redirect()->route('admin.profile.requests')->with('success', 'Profile request approved successfully.');
    }

    // Admin - reject request
    public function reject(Request $request, ProfileRequest $profileRequest)
    {
        $request->validate([
            'admin_note' => 'nullable|string|max:255',
        ]);

        $profileRequest->update([
            'status'     => 'rejected',
            'admin_note' => $request->admin_note,
        ]);

        return redirect()->route('admin.profile.requests')->with('success', 'Profile request rejected.');
    }
}