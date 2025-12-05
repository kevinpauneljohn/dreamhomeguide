<?php

namespace App\View\Components;

use App\Services\PropertyService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InquiryForm extends Component
{
    public array $propertyCategories;
    /**
     * Create a new component instance.
     */
    public function __construct(
        PropertyService $propertyService,
        public ?string $leadType = null
    )
    {
        $this->propertyCategories = $propertyService->propertyCategories();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.inquiry-form');
    }
}
