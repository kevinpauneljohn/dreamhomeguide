<?php

namespace App\View\Components\Tools;

use App\Models\Project;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Computation extends Component
{
    public \Illuminate\Database\Eloquent\Collection $projects;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->projects = Project::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tools.computation');
    }
}
