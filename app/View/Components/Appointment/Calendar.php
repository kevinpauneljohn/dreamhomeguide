<?php

namespace App\View\Components\Appointment;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Calendar extends Component
{
    public string $getAllUrl;
    /**
     * Create a new component instance.
     */
    public function __construct(
        public bool $editable = true,
        public bool $displayAll = false
    )
    {
        $this->getAllUrl = $this->displayAll
            ? route('get-appointments')
            : route('get-user-appointment',['userId' => auth()->id()]);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.appointment.calendar');
    }
}
