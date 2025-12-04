<?php

namespace App\View\Components;

use App\Services\PropertyService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SearchProperty extends Component
{
    public array $propertyCategories;
    public array $propertyTypes;
    public array $location;
    /**
     * Create a new component instance.
     */
    public function __construct(
        protected PropertyService $propertyService
    )
    {
        $this->propertyCategories = $this->propertyService->propertyCategories();
        $this->propertyTypes = $this->propertyService->propertyTypes();
        $this->location = $this->propertyService->location();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.search-property');
    }
}
