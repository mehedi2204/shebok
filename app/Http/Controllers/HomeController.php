<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use App\Models\Package;
use App\Models\ProviderProfile;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::withCount(['providers' => function($query) {
            $query->where('status', 'approved');
        }])->take(4)->get();

        $totalProviders = ProviderProfile::where('status', 'approved')->count();

        return view('user.index', compact('categories', 'totalProviders'));
    }

    public function packages()
    {
        $packages = Package::where('is_active', true)->get();
        return view('user.packages', compact('packages'));
    }

    public function about()
    {
        return view('user.about');
    }

    public function contact()
    {
        return view('user.contact');
    }

    public function storeContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        \App\Models\ContactMessage::create($request->all());

        return back()->with('success', 'Your message has been sent successfully. We will get back to you soon!');
    }

    public function help()
    {
        return view('user.help');
    }

    public function privacy()
    {
        return view('user.privacy');
    }

    public function terms()
    {
        return view('user.terms');
    }
}
