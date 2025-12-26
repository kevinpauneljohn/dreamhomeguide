<?php

namespace App\Observers;

use App\Models\Leads;
use App\Services\LeadService;

readonly class LeadObserver
{
    public function __construct(private LeadService $leadService)
    {

    }
    /**
     * Handle the Leads "created" event.
     */
    public function created(Leads $leads): void
    {
        //only notify users when a lead was created organically or submitted by the client itself
        if(is_null($leads->user_id))
        {
            $roles = ['super admin','manager'];
            $this->leadService->notify_users_when_lead_created($roles, $leads);
        }

    }

    /**
     * Handle the Leads "updated" event.
     */
    public function updated(Leads $leads): void
    {
        //
    }

    /**
     * Handle the Leads "deleted" event.
     */
    public function deleted(Leads $leads): void
    {
        //
    }

    /**
     * Handle the Leads "restored" event.
     */
    public function restored(Leads $leads): void
    {
        //
    }

    /**
     * Handle the Leads "force deleted" event.
     */
    public function forceDeleted(Leads $leads): void
    {
        //
    }
}
