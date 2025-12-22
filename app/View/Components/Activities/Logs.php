<?php

namespace App\View\Components\Activities;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Logs extends Component
{
    public string $url = '';
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string|null $leadId = null,
        public string|null $userId = null
    )
    {
        if(!is_null($leadId))
        {
            $this->url = route('activities.leads', ['lead' => $leadId]);
        }
        elseif(!is_null($userId))
        {
            $this->url = route('activities.user', ['user' => $userId]);
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.activities.logs');
    }
}
