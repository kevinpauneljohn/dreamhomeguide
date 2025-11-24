<?php

namespace App\Services;

use App\Models\Property;
use App\Models\PropertyImage;
use Yajra\DataTables\Facades\DataTables;

class PropertyService
{

    public function saveProperty(array $data): \Illuminate\Http\JsonResponse
    {
        $property = Property::create(collect($data)->merge(['user_id' => auth()->id()])->toArray());
        return  $property ?
            response()->json(['success' => true, 'message' => 'Property created successfully!', 'property_id' => $property->id], 201) :
            response()->json(['success' => false, 'message' => 'Something went wrong!'], 500);
    }

    public function getQuery(array $request): \Illuminate\Database\Eloquent\Builder
    {
        $query = Property::query();

        // Search
        if ($request['search']) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', "%{$request['search']}%")
                    ->orWhere('location', 'like', "%{$request['search']}%")
                    ->orWhere('property_type', 'like', "%{$request['search']}%");
            });
        }

        // Listing Type (sale, rent, preselling)
        if ($request['listingType']) {
            $query->where('property_type', $request['listingType']);
        }

        // Category (house, condo, lot)
        if ($request['category']) {
            $query->where('property_category', $request['category']);
        }

        // Status (active, reserved, sold)
        if ($request['status']) {
            $query->where('status', $request['status']);
        }

        return $query;
    }
    public function getProperties($request): \Illuminate\Http\JsonResponse
    {
        $query = $this->getQuery($request);
        return DataTables::of($query)
            ->addColumn('thumbnail', function ($property) {
                return [
                    'with_images' => $property->images->count() > 0,
                    'thumbnail' => $property->images->where('is_thumbnail', true)->first()
                ];
            })
            ->addColumn('images_count', function ($property) {
                return $property->images->count();
            })
            ->addColumn('action', content: function ($property) {
                return [
                    'view' => (bool)auth()->user()->can('view listing'),
                    'edit' => (bool)auth()->user()->can('edit listing'),
                    'upload_images' => (bool)auth()->user()->can('upload listing images'),
                    'delete' => (bool)auth()->user()->can('delete listing'),
                    'id' => $property->id
                ];
            })
            ->make(true);
    }


    public function getPropertyImages($property_id): \Illuminate\Http\JsonResponse
    {
        $propertyImages = PropertyImage::where('property_id', $property_id)->get();
        return DataTables::of($propertyImages)
            ->addColumn('action', content: function ($property) {
                return [
                    'edit' => (bool)auth()->user()->can('edit listing'),
                    'delete' => (bool)auth()->user()->can('delete listing'),
                    'id' => $property->id
                ];
            })
            ->make(true);
    }
}
