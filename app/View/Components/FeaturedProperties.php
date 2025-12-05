<?php

namespace App\View\Components;

use App\Models\Property;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FeaturedProperties extends Component
{

    /**
     * Create a new component instance.
     */
    public function __construct(public $properties)
    {
        $this->properties = Property::where('is_featured',true)->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.featured-properties');
    }
}
