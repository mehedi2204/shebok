<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ProviderProfile;
use App\Models\ServiceCategory;
use App\Models\Location;
use App\Models\Package;
use App\Models\Setting;
use App\Models\CategoryField;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_providers' => ProviderProfile::count(),
            'pending_approvals' => ProviderProfile::where('status', 'pending')->count(),
            'total_categories' => ServiceCategory::count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }

    public function categories()
    {
        $categories = ServiceCategory::withCount('providers')->get();
        return view('admin.categories', compact('categories'));
    }

    public function editCategory($id)
    {
        $category = ServiceCategory::findOrFail($id);
        return view('admin.edit_category', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $category = ServiceCategory::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'icon_type' => 'required|in:predefined,upload',
            'icon_predefined' => 'required_if:icon_type,predefined',
            'icon_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $icon = $category->icon;
        if ($request->icon_type === 'upload' && $request->hasFile('icon_upload')) {
            $path = $request->file('icon_upload')->store('icons', 'public');
            $icon = 'storage/' . $path;
        } elseif ($request->icon_type === 'predefined') {
            $icon = $request->icon_predefined;
        }

        $category->update([
            'name' => $request->name,
            'tagline' => $request->tagline,
            'icon' => $icon,
            'require_certificate' => $request->has('require_certificate'),
            'require_experience' => $request->has('require_experience'),
        ]);

        return redirect()->route('admin.categories')->with('success', 'Category updated.');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'icon_type' => 'required|in:predefined,upload',
            'icon_predefined' => 'required_if:icon_type,predefined',
            'icon_upload' => 'required_if:icon_type,upload|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $icon = null;
        if ($request->icon_type === 'upload' && $request->hasFile('icon_upload')) {
            $path = $request->file('icon_upload')->store('icons', 'public');
            $icon = 'storage/' . $path;
        } else {
            $icon = $request->icon_predefined;
        }

        ServiceCategory::create([
            'name' => $request->name,
            'tagline' => $request->tagline,
            'icon' => $icon,
            'require_certificate' => $request->has('require_certificate'),
            'require_experience' => $request->has('require_experience'),
        ]);

        return back()->with('success', 'Category created.');
    }

    public function deleteCategory($id)
    {
        ServiceCategory::findOrFail($id)->delete();
        return back()->with('success', 'Category deleted.');
    }

    public function locations()
    {
        $countries = Location::where('type', 'country')->get();
        $divisions = Location::where('type', 'division')->with('parent')->get();
        $cities = Location::where('type', 'city')->with('parent')->get();
        return view('admin.locations', compact('countries', 'divisions', 'cities'));
    }

    public function storeLocation(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:country,division,city',
            'parent_id' => 'nullable|exists:locations,id',
        ]);

        Location::create($request->only('name', 'type', 'parent_id'));
        return back()->with('success', 'Location added.');
    }

    public function deleteLocation($id)
    {
        $location = Location::findOrFail($id);

        // Check if it has children
        if (Location::where('parent_id', $id)->exists()) {
            return back()->with('error', 'Cannot delete this location because it has sub-locations (divisions or cities).');
        }

        $location->delete();
        return back()->with('success', 'Location deleted.');
    }

    public function approvals()
    {
        $pendingProviders = ProviderProfile::with('user', 'category')->where('status', 'pending')->get();
        $updateRequests = ProviderProfile::with('user', 'category')->whereNotNull('pending_update')->get();
        return view('admin.approvals', compact('pendingProviders', 'updateRequests'));
    }

    public function approveUpdate($id)
    {
        $provider = ProviderProfile::findOrFail($id);
        if ($provider->pending_update) {
            $provider->update($provider->pending_update);
            $provider->update(['pending_update' => null]);
        }
        return back()->with('success', 'Update request approved.');
    }

    public function rejectUpdate($id)
    {
        $provider = ProviderProfile::findOrFail($id);
        $provider->update(['pending_update' => null]);
        return back()->with('success', 'Update request rejected.');
    }

    public function approveProvider($id)
    {
        $provider = ProviderProfile::findOrFail($id);
        $provider->update(['status' => 'approved']);
        return back()->with('success', 'Provider approved successfully.');
    }

    public function rejectProvider($id)
    {
        $provider = ProviderProfile::findOrFail($id);
        $provider->update(['status' => 'rejected']);
        return back()->with('success', 'Provider rejected.');
    }

    public function users(Request $request)
    {
        $query = User::with('providerProfile.category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('approval')) {
            $query->whereHas('providerProfile', function($q) use ($request) {
                $q->where('status', $request->approval);
            });
        }

        if ($request->filled('category_id')) {
            $query->whereHas('providerProfile', function($q) use ($request) {
                $q->where('category_id', $request->category_id);
            });
        }

        if ($request->filled('country_id')) {
            $query->whereHas('providerProfile', function($q) use ($request) {
                $q->where('country_id', $request->country_id);
            });
        }

        if ($request->filled('division_id')) {
            $query->whereHas('providerProfile', function($q) use ($request) {
                $q->where('division_id', $request->division_id);
            });
        }

        if ($request->filled('district_id')) {
            $query->whereHas('providerProfile', function($q) use ($request) {
                $q->where('district_id', $request->district_id);
            });
        }

        $users = $query->latest()->paginate(20)->withQueryString();

        $categories = ServiceCategory::all();
        $countries = Location::where('type', 'country')->get();

        return view('admin.users', compact('users', 'categories', 'countries'));
    }

    public function showUser($id)
    {
        $user = User::with('providerProfile.category', 'providerProfile.reviews')->findOrFail($id);
        return view('admin.view_user', compact('user'));
    }

    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();
        return back()->with('success', 'User status updated.');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit_user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,user',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8']);
            $user->password = bcrypt($request->password);
            $user->save();
        }

        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return back()->with('error', 'Cannot delete the last administrator.');
        }
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    public function packages()
    {
        $packages = Package::all();
        return view('admin.packages', compact('packages'));
    }

    public function storePackage(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'duration_days' => 'required|integer',
            'features' => 'nullable|string', // comma separated
        ]);

        $features = $request->features ? array_map('trim', explode(',', $request->features)) : [];

        Package::create([
            'name' => $request->name,
            'price' => $request->price,
            'duration_days' => $request->duration_days,
            'features' => $features,
            'is_active' => true,
        ]);

        return back()->with('success', 'Package created.');
    }

    public function deletePackage($id)
    {
        Package::findOrFail($id)->delete();
        return back()->with('success', 'Package deleted.');
    }

    public function settings()
    {
        $settings = Setting::pluck('value', 'key');
        return view('admin.settings', compact('settings'));
    }

    public function messages()
    {
        $messages = \App\Models\ContactMessage::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.messages', compact('messages'));
    }

    public function showMessage($id)
    {
        $message = \App\Models\ContactMessage::findOrFail($id);
        $message->update(['is_read' => true]);
        return view('admin.view_message', compact('message'));
    }

    public function deleteMessage($id)
    {
        \App\Models\ContactMessage::findOrFail($id)->delete();
        return back()->with('success', 'Message deleted.');
    }

    public function formBuilder(Request $request)
    {
        $categories = ServiceCategory::all();
        $selectedCategoryId = $request->query('category_id', $categories->first()->id ?? null);
        $selectedCategory = null;
        $fields = [];

        if ($selectedCategoryId) {
            $selectedCategory = ServiceCategory::find($selectedCategoryId);
            $fields = CategoryField::where('category_id', $selectedCategoryId)->orderBy('order')->get();
        }

        return view('admin.form_builder', compact('categories', 'selectedCategory', 'fields'));
    }

    public function storeField(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:service_categories,id',
            'label' => 'required|string',
            'type' => 'required|string',
        ]);

        CategoryField::create([
            'category_id' => $request->category_id,
            'label' => $request->label,
            'type' => $request->type,
            'is_required' => $request->has('is_required'),
            'order' => CategoryField::where('category_id', $request->category_id)->count(),
        ]);

        return back()->with('success', 'Field added.');
    }

    public function deleteField($id)
    {
        CategoryField::findOrFail($id)->delete();
        return back()->with('success', 'Field deleted.');
    }

    public function updateSettings(Request $request)
    {
        $data = $request->except('_token');

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
