<?php

namespace App\View\Components;

use App\Models\PropertyImage;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListingImages extends Component
{
    public $images;
    /**
     * Create a new component instance.
     */
    public function __construct(public int $propertyId)
    {
        $this->images = PropertyImage::where('property_id', $this->propertyId)->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.listing-images');
    }
}
