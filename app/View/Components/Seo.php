<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Seo extends Component
{
    public string $title;
    public string $description;
    public string $keywords;
    public mixed $image;
    public mixed $schemaType;
    public string $canonical;
    /**
     * Create a new component instance.
     */
    public function __construct(
        $title = null,
        $description = null,
        $keywords = null,
        $image = null,
        $schemaType = 'WebSite',
        $canonical = null
    )
    {
        $this->title = $title ?? 'John Kevin Paunel | Pampanga Real Estate';
        $this->description = $description ?? 'Find the best house and lot for sale in Pampanga, Angeles, Mabalacat, Clark, and Central Luzon.';
        $this->keywords = $keywords ?? 'pampanga real estate, house and lot for sale, angeles city, clark, dream home guide realty';
        $this->image = $image ?? asset('images/logo.png');
        $this->schemaType = $schemaType;
        $this->canonical = $canonical ?? url()->current();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.seo');
    }
}
