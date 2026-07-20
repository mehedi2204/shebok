<?php

namespace App\Http\Controllers;

use App\Models\ProviderProfile;
use App\Models\ServiceCategory;
use App\Models\Review;
use App\Models\SavedProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = ProviderProfile::with('user', 'category')->where('status', 'approved');

        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        $providers = $query->paginate(12);
        $categories = ServiceCategory::all();

        return view('user.services', compact('providers', 'categories'));
    }

    public function show(Request $request, $id)
    {
        $provider = ProviderProfile::with('user', 'category', 'reviews.user')->findOrFail($id);

        // Only count view if it's not the owner and it's a unique session/IP visit
        if (Auth::id() !== $provider->user_id) {
            $viewKey = 'viewed_provider_' . $id;
            if (!$request->session()->has($viewKey)) {
                $provider->increment('views');
                $request->session()->put($viewKey, true);
            }
        }

        return view('user.provider_profile', compact('provider'));
    }

    public function showSetupProfile()
    {
        $categories = ServiceCategory::with('fields')->get();
        $profile = Auth::user()->providerProfile;
        $countries = \App\Models\Location::where('type', 'country')->get();
        $divisions = $profile ? \App\Models\Location::where('parent_id', $profile->country_id)->get() : [];
        $districts = $profile ? \App\Models\Location::where('parent_id', $profile->division_id)->get() : [];

        return view('user.setup_profile', compact('categories', 'profile', 'countries', 'divisions', 'districts'));
    }

    public function storeProfile(Request $request)
    {
        $user = Auth::user();
        $profile = $user->providerProfile;

        // If approved, we handle this as an update request
        if ($profile && $profile->status === 'approved') {
            return $this->handleUpdateRequest($request, $profile);
        }

        $category = ServiceCategory::findOrFail($request->category_id);

        $rules = [
            'category_id' => 'required|exists:service_categories,id',
            'profession' => 'required|string',
            'bio' => 'nullable|string',
            'experience' => 'nullable|string',
            'hourly_rate' => 'required|numeric',
            'rate_type' => 'required|in:hourly,daily,weekly,monthly',
            'country_id' => 'required|exists:locations,id',
            'division_id' => 'required|exists:locations,id',
            'district_id' => 'required|exists:locations,id',
            'thana_upazila' => 'nullable|string',
            'address' => 'required|string',
            'nid' => ($profile && $profile->nid_path) ? 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240' : 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
        ];

        if ($category->require_certificate) {
            $rules['certificate'] = ($profile && $profile->certificate_path) ? 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240' : 'required|file|mimes:pdf,jpg,jpeg,png|max:10240';
        } else {
            $rules['certificate'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240';
        }

        if ($category->require_experience) {
            $rules['experience_file'] = ($profile && $profile->experience_path) ? 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240' : 'required|file|mimes:pdf,jpg,jpeg,png|max:10240';
        } else {
            $rules['experience_file'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240';
        }

        $request->validate($rules);

        // Generate combined location string for easy search/display
        $district = \App\Models\Location::find($request->district_id);
        $division = \App\Models\Location::find($request->division_id);
        $locationString = ($request->thana_upazila ? $request->thana_upazila . ', ' : '') . $district->name . ', ' . $division->name;

        $data = [
            'category_id' => $request->category_id,
            'profession' => $request->profession,
            'bio' => $request->bio,
            'experience' => $request->experience,
            'price_per_hour' => $request->hourly_rate,
            'rate_type' => $request->rate_type,
            'country_id' => $request->country_id,
            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'thana_upazila' => $request->thana_upazila,
            'location' => $locationString,
            'address' => $request->address,
            'status' => 'pending',
        ];

        if ($request->hasFile('nid')) {
            $path = $request->file('nid')->store('verification', 'public');
            $data['nid_path'] = $path;
        }
        if ($request->hasFile('license')) {
            $path = $request->file('license')->store('verification', 'public');
            $data['license_path'] = $path;
        }
        if ($request->hasFile('certificate')) {
            $path = $request->file('certificate')->store('verification', 'public');
            $data['certificate_path'] = $path;
        }
        if ($request->hasFile('experience_file')) {
            $path = $request->file('experience_file')->store('verification', 'public');
            $data['experience_path'] = $path;
        }

        // Handle dynamic fields
        $category = ServiceCategory::find($request->category_id);
        $additionalData = [];
        foreach ($category->fields as $field) {
            $fieldName = 'field_' . $field->id;
            if ($request->has($fieldName)) {
                $additionalData[$field->label] = $request->get($fieldName);
            }
        }
        $data['additional_data'] = $additionalData;

        ProviderProfile::updateOrCreate(
            ['user_id' => Auth::id()],
            $data
        );

        return redirect('/user/dashboard')->with('success', 'Profile submitted for approval.');
    }

    protected function handleUpdateRequest(Request $request, $profile)
    {
        $request->validate([
            'profession' => 'required|string',
            'bio' => 'nullable|string',
            'experience' => 'nullable|string',
            'hourly_rate' => 'required|numeric',
            'rate_type' => 'required|in:hourly,daily,weekly,monthly',
            'country_id' => 'required|exists:locations,id',
            'division_id' => 'required|exists:locations,id',
            'district_id' => 'required|exists:locations,id',
            'thana_upazila' => 'nullable|string',
            'address' => 'required|string',
        ]);

        $district = \App\Models\Location::find($request->district_id);
        $division = \App\Models\Location::find($request->division_id);
        $locationString = ($request->thana_upazila ? $request->thana_upazila . ', ' : '') . $district->name . ', ' . $division->name;

        $updateData = [
            'profession' => $request->profession,
            'bio' => $request->bio,
            'experience' => $request->experience,
            'price_per_hour' => $request->hourly_rate,
            'rate_type' => $request->rate_type,
            'country_id' => $request->country_id,
            'division_id' => $request->division_id,
            'district_id' => $request->district_id,
            'thana_upazila' => $request->thana_upazila,
            'location' => $locationString,
            'address' => $request->address,
        ];

        // Handle dynamic fields for update
        $category = $profile->category;
        $additionalData = [];
        foreach ($category->fields as $field) {
            $fieldName = 'field_' . $field->id;
            if ($request->has($fieldName)) {
                $additionalData[$field->label] = $request->get($fieldName);
            }
        }
        $updateData['additional_data'] = $additionalData;

        // Check if admin requires approval for updates
        $requireApproval = \App\Models\Setting::get('require_approval', '1') == '1';

        if ($requireApproval) {
            $profile->update(['pending_update' => $updateData]);
            return back()->with('success', 'Your update request has been submitted for admin approval.');
        } else {
            $profile->update($updateData);
            return back()->with('success', 'Profile updated successfully.');
        }
    }

    public function rateProvider(Request $request, $id)
    {
        $provider = ProviderProfile::findOrFail($id);

        if (Auth::id() === $provider->user_id) {
            return back()->with('error', 'You cannot rate your own profile.');
        }

        $alreadyRated = Review::where('user_id', Auth::id())
            ->where('provider_profile_id', $id)
            ->where('rating', '>', 0)
            ->exists();

        $request->validate([
            'rating' => $alreadyRated ? 'nullable|integer|min:0|max:5' : 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        Review::create([
            'user_id' => Auth::id(),
            'provider_profile_id' => $id,
            'rating' => $alreadyRated ? 0 : $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', $alreadyRated ? 'Review comment added.' : 'Thank you for your rating and review!');
    }

    public function saveProfile($id)
    {
        $provider = ProviderProfile::findOrFail($id);

        if (Auth::id() === $provider->user_id) {
            return back()->with('error', 'You cannot shortlist your own profile.');
        }

        $saved = SavedProfile::where('user_id', Auth::id())
            ->where('provider_profile_id', $id)
            ->first();

        if ($saved) {
            $saved->delete();
            return back()->with('success', 'Profile removed from your shortlist.');
        }

        SavedProfile::create([
            'user_id' => Auth::id(),
            'provider_profile_id' => $id,
        ]);

        return back()->with('success', 'Profile saved to your shortlist.');
    }
}
