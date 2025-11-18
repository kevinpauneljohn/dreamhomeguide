<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Services\PermissionService;
use App\Services\PropertyService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.pages.properties.index',[
            'title' => 'Properties',
            'permissions' => Permission::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pages.properties.create',[
            'title' => 'Create Property'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePropertyRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        // Convert JSON gallery to array
        $property->gallery = $property->gallery ? json_decode($property->gallery, true) : [];

        $property->full_location = $property->street . ', ' . $property->city;

        // Auto-determine status color
        $property->status_color = match($property->status) {
            'Active'   => 'success',
            'Reserved' => 'warning',
            'Sold'     => 'danger',
            default    => 'secondary'
        };

        $title = ucwords($property->title);

        return view('dashboard.pages.properties.show', compact('property','title'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePropertyRequest $request, Property $property)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        //
    }

    public function permission(PermissionService $permissionService)
    {
        return $permissionService->permissions();
    }

    public function properties(Request $request, PropertyService $propertyService)
    {
        $query = Property::query();

        // Search
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhere('address', 'like', "%{$request->search}%")
                    ->orWhere('type', 'like', "%{$request->search}%");
            });
        }

        // Listing Type (sale, rent, preselling)
        if ($request->listingType) {
            $query->where('type', $request->listingType);
        }

        // Category (house, condo, lot)
        if ($request->category) {
            $query->where('category', $request->category);
        }

        // Status (active, reserved, sold)
        if ($request->status) {
            $query->where('status', $request->status);
        }

        return $propertyService->getProperties($query);
    }

}
