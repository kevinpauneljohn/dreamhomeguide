<?php

namespace App\Http\Controllers;

use App\Models\PropertyImage;
use Illuminate\Http\Request;

class PropertyImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PropertyImage $propertyImage): PropertyImage
    {
        return $propertyImage;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PropertyImage $propertyImage): \Illuminate\Http\JsonResponse
    {
        if($propertyImage->fill($request->all())->isDirty())
        {
            $this->removeCurrentThumbnail($propertyImage->is_thumbnail, $propertyImage->property_id);
            if($propertyImage->save())
            {

                return response()->json(['success' => true, 'message' => 'Property image updated successfully.']);
            }
            return response()->json(['success' => false, 'message' => 'An error occurred while updating the property image.']);
        }
        return response()->json(['success' => false, 'message' => 'No changes were made.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PropertyImage $propertyImage): \Illuminate\Http\JsonResponse
    {
       unlink(public_path("storage/property_images/".$propertyImage->file_name));
        return $propertyImage->delete() ?
            response()->json(['success' => true, 'message' => 'Property image deleted successfully.']) :
            response()->json(['success' => false, 'message' => 'An error occurred while deleting the property image.']);
    }

    private function removeCurrentThumbnail(bool $is_thumbnail, $property_id): void
    {
        if($is_thumbnail){
            PropertyImage::where('property_id', $property_id)->update(['is_thumbnail' => false]);
        }
    }
}
