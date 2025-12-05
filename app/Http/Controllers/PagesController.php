<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitListingRequest;
use App\Services\PropertyService;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function listMyProperty(PropertyService $propertyService): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('pages.list-my-property')->with([
            'propertyCategories' => $propertyService->propertyCategories(),
        ]);
    }

    public function submitListing(SubmitListingRequest $request)
    {
        return $request->all();
    }
}
