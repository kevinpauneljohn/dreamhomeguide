<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePropertyImageRequest;
use App\Models\Property;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Models\PropertyImage;
use App\Services\PropertyService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Spatie\Permission\Models\Permission;

class PropertyController extends Controller
{
    public function __construct(
        protected PropertyService $propertyService
    )
    {

    }

    public static function middleware(): array
    {
        return [
            new Middleware('can:view listing', only: ['index', 'show','properties','propertyImages']),
            new Middleware('can:add listing', only: ['create', 'store']),
            new Middleware('can:edit listing', only: ['edit', 'update']),
            new Middleware('can:delete listing', only: ['destroy']),
            new Middleware('can:upload listing images', only: ['uploadPropertyImages'])
        ];
    }

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
        abort_if(!auth()->user()->can('add listing'), 403);
        return view('dashboard.pages.properties.create',[
            'title' => 'Create Property',
            'propertyCategories' => $this->propertyService->propertyCategories(),
            'propertyTypes' => $this->propertyService->propertyTypes(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePropertyRequest $request, PropertyService $propertyService)
    {
        return $propertyService->saveProperty($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        // Convert JSON gallery to array
        $property->images = $property->images ? json_decode($property->images, true) : [];

        // Auto-determine status color
        $property->status_color = match($property->status) {
            'active'   => 'success',
            'reserved' => 'warning',
            'sold'     => 'danger',
            default    => 'secondary'
        };

        $thumbnail = collect($property->images)->count() > 0 && $property->images()->where('is_thumbnail', true)->count() > 0 ?
            '/storage/property_images/'.$property->images()->where('is_thumbnail', true)->first()->file_name :
            'https://img.freepik.com/premium-vector/default-image-icon-vector-missing-picture-page-website-design-mobile-app-no-photo-available_87543-11093.jpg';
        $title = ucwords($property->title);

        return view('dashboard.pages.properties.show', compact('property','title','thumbnail'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        abort_if(!auth()->user()->can('edit listing'), 403);
        return view('dashboard.pages.properties.edit',[
            'title' => 'Edit Property',
            'property' => $property
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePropertyRequest $request, Property $property)
    {
        if($property->fill($request->all())->isDirty())
        {
            $property->save();
            return response()->json(['success' => true, 'message' => 'Property updated successfully.']);
        }else{
            return response()->json(['success' => false, 'message' => 'No changes were made.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        return $property->delete() ?
            response()->json(['success' => true, 'message' => 'Property deleted successfully.']) :
            response()->json(['success' => false, 'message' => 'An error occurred while deleting the property.']);
    }

    public function properties(Request $request, PropertyService $propertyService): \Illuminate\Http\JsonResponse
    {
        return $propertyService->getProperties($request->all());
    }

    public function propertyImages(Property $property): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        return view('dashboard.pages.properties.gallery',[
            'title' => 'Gallery',
            'property' => $property
        ]);
    }

    public function uploadPropertyImages(StorePropertyImageRequest $request): \Illuminate\Http\JsonResponse
    {
        if($request->hasFile('file'))
        {
            $file = $request->file('file');

            $newName = time(). '-' . uniqid() . '.' . $file->extension();
            $file->move(public_path('storage/property_images'),$newName);

            if(PropertyImage::create([
                'property_id' => $request->property_id,
                'file_name' => $newName,
                'extension' => $file->getClientOriginalExtension(),
            ]))
            {
                return response()->json(['success' => true, 'message' => 'File uploaded successfully.']);
            }
        }
        return response()->json(['success' => false, 'message' => 'An error occurred while uploading the file.']);
    }

    public function images(PropertyService $propertyService, $property_id)
    {
        return $propertyService->getPropertyImages($property_id);
    }
}
