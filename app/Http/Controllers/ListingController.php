<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyView;
use App\Services\PropertyService;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function __construct(
        protected PropertyService $propertyService
    )
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('pages.listings.listing')->with(
            [
                'title' => 'Listings',
                'properties' => $this->propertyService->searchProperties($request->all()),
                'searchQueryCount' => $this->propertyService->searchPropertyQuery($request->all())->count(),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        //
    }

    public function showBySlug(string $slug, Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $property = Property::where('slug',$slug)->firstOrFail();


        $this->propertyService->propertyViewsRecording($property, $request);

        return view('pages.listings.profile')->with([
            'title' => ucwords(strtolower($property->title)),
            'property' => $property,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
