<?php

namespace App\Services;

use App\Models\Property;
use App\Models\PropertyImage;
use Yajra\DataTables\Facades\DataTables;

class PropertyService
{

    public function saveProperty(array $data): \Illuminate\Http\JsonResponse
    {
        $property = Property::create(collect($data)->merge([
            'user_id' => auth()->id(),
        ])->toArray());

        return  $property ?
            response()->json(['success' => true, 'message' => 'Property created successfully!', 'property_id' => $property->id], 201) :
            response()->json(['success' => false, 'message' => 'Something went wrong!'], 500);
    }

    private function propertyQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Property::query()->latest('created_at', 'desc');
    }

    public function getQuery(array $request): \Illuminate\Database\Eloquent\Builder
    {
        $query = $this->propertyQuery();

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
                    'with_thumbnail' => $property->images->where('is_thumbnail', true)->count() > 0,
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
                    'id' => $property->id,
                    'slug' => $property->slug,
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

    public function propertyTypes(): array
    {
        return [
            'sale' => 'For Sale',
            'rent' => 'For Rent',
            'preselling' => 'Pre-Selling',
        ];
    }

    public function propertyCategories(): array
    {
        return [
            'house-and-lot' => 'House and Lot',
            'condominium' => 'Condominium',
            'apartment' => 'Apartment',
            'office' => 'Office',
            'commercial' => 'Commercial',
            'industrial' => 'Industrial',
            'warehouse' => 'Warehouse',
            'land' => 'Land',
            'lot' => 'Lot',
        ];
    }

    public function propertyStatus(): array
    {
        return [
            'active' => 'Active',
            'reserved' => 'Reserved',
            'sold' => 'Sold',
        ];
    }

    public function propertyFeatures(): array
    {
        return [
            'elevator' => 'Elevator',
            'parking' => 'Parking',
            'gym' => 'Gym',
            'swimming_pool' => 'Swimming Pool',
            'laundry' => 'Laundry',
            'furnished' => 'Furnished',
            'furnished_unfurnished' => 'Furnished/Unfurnished',
            'furnished_partially_furnished' => 'Furnished/Partially Furnished',
        ];
    }

    public function location(): array
    {
        return [
            'pampanga' => 'Pampanga',
            'tarlac' => 'Tarlac',
            'bulacan' => 'Bulacan',
            'bataan' => 'Bataan',
        ];
    }

    public function searchPropertyQuery($request): \Illuminate\Database\Eloquent\Builder
    {
        $query = $this->propertyQuery();

        if(array_key_exists('category', $request) && !empty($request['category']) )
        {
            $query->where('property_category', $request['category']);
        }

        if(array_key_exists('purpose', $request) && !empty($request['purpose']) )
        {
            $query->where('property_type', $request['purpose']);
        }

        if(array_key_exists('location', $request) && !empty($request['location']) )
        {
            $query->where('location', 'like', "%{$request['location']}%");
        }

        if(array_key_exists('room', $request) && !empty($request['room']) )
        {
            $query->where('bedrooms', $request['room']);
        }

        if(array_key_exists('garage', $request) && !empty($request['garage']) )
        {
            $query->where('garage', $request['garage']);
        }

        if(array_key_exists('minPrice', $request) && !empty($request['minPrice']) )
        {
            $query->where('price','>=', (int)$request['minPrice'].'000000');
        }

        if(array_key_exists('maxPrice', $request) && !empty($request['maxPrice']) )
        {
            $query->where('price','<=', (int)$request['maxPrice'].'000000');
        }

        if(array_key_exists('minArea', $request) && !empty($request['minArea']) )
        {
            $query->where('lot_area','>=', (int)$request['minArea']);
        }

        if(array_key_exists('maxArea', $request) && !empty($request['maxArea']) )
        {
            $query->where('lot_area','<=', (int)$request['maxArea']);
        }

        return $query;
    }

    public function searchProperties($request): \Illuminate\Pagination\LengthAwarePaginator
    {
        $query = $this->searchPropertyQuery($request);
        return $query->paginate(12);
    }
}
