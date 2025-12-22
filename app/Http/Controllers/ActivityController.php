<?php

namespace App\Http\Controllers;

use App\Services\ActivityService;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityController extends Controller
{

    public function __construct(
        public ActivityService $activityService
    )
    {

    }
    public function getActivitiesByLeads(string $leadId): \Illuminate\Http\JsonResponse
    {
        $activities = Activity::where('properties->lead_id', $leadId)
            ->latest()
            ->get();

        return $this->activityService->getActivities($activities);
    }

    public function getActivitiesByUser(string $userId): \Illuminate\Http\JsonResponse
    {
        $activities = Activity::where('causer_id', $userId)
            ->latest()
            ->get();

        return $this->activityService->getActivities($activities);
    }
}
