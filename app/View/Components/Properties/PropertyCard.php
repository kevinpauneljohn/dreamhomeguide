<?php

namespace App\View\Components\Properties;

use App\Models\Property;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PropertyCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Property $property
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.properties.property-card');
    }
}
