<?php

namespace App\View\Components;

use App\Models\Property;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FeaturedProperties extends Component
{

    public $featuredProperties;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->featuredProperties = Property::where('is_featured',true)->where('status','!=','inactive')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.featured-properties');
    }
}
