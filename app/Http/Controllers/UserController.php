<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ProviderProfile;
use App\Models\SavedProfile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        }

        $providerProfile = $user->providerProfile;
        $savedProfiles = SavedProfile::where('user_id', $user->id)->with('providerProfile.user', 'providerProfile.category')->get();

        $stats = [
            'views' => $providerProfile ? $providerProfile->views : 0,
            'connections' => \App\Models\Conversation::where('sender_id', $user->id)->orWhere('receiver_id', $user->id)->count(),
            'shortlists' => $providerProfile ? $providerProfile->reviews()->count() : 0,
            'rating' => $providerProfile ? $providerProfile->averageRating() : 0,
        ];

        return view('user.dashboard', compact('user', 'providerProfile', 'savedProfiles', 'stats'));
    }

    public function showProfile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'current_password' => 'required_with:password|nullable',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'The provided current password does not match our records.']);
            }
            $user->password = Hash::make($request->password);
        }

        $user->name = $request->name;
        if ($request->has('phone')) {
            $user->phone = $request->phone;
        }

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    public function toggleProviderStatus()
    {
        $profile = Auth::user()->providerProfile;
        if (!$profile || $profile->status !== 'approved') {
            return back()->with('error', 'Only approved providers can toggle status.');
        }

        $profile->is_available = !$profile->is_available;
        $profile->save();

        return back()->with('success', 'Profile status updated.');
    }

    public function deleteAccount(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'reason' => 'required|string',
            'password' => 'required',
        ]);

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['delete_password' => 'The provided password does not match our records.']);
        }

        // Optional: Log the reason somewhere if needed
        // \Log::info("User {$user->email} deleted their account. Reason: {$request->reason}");

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Your account has been permanently deleted.');
    }
}
