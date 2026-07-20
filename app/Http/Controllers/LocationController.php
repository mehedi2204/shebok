<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function getChildren($parentId)
    {
        $locations = Location::where('parent_id', $parentId)->orderBy('name')->get();
        return response()->json($locations);
    }

    public function getCountries()
    {
        $countries = Location::where('type', 'country')->orderBy('name')->get();
        return response()->json($countries);
    }
}
