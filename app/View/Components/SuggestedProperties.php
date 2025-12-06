<?php

namespace App\View\Components;

use App\Models\Property;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SuggestedProperties extends Component
{
    public $suggestedProperties;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->suggestedProperties = Property::count() > 2 ? Property::all()->random(3) : Property::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.suggested-properties');
    }
}
