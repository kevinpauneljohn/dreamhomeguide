<?php

namespace App\Services;

use App\Models\Leads;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;

class ActivityService
{
    public function getActivities($activities): \Illuminate\Http\JsonResponse
    {
        return DataTables::of($activities)
            ->addColumn('icon', fn ($activity) => $activity->event)
            ->addColumn('description', fn ($activity) => $activity->description)
            ->addColumn('log_name', fn ($activity) => $activity->log_name)
            ->addColumn('causer', fn ($activity) => $activity->causer?->full_name ?? 'System')
            ->addColumn('causer_id', fn ($activity) => $activity->causer?->id ?? 'System')
            ->addColumn('time_ago', fn ($a) => $a->created_at->diffForHumans())
            ->addColumn('exact_date', fn ($a) => $a->created_at->format('M d, Y h:i A'))
            ->rawColumns(['icon', 'description'])
            ->editColumn('properties', function ($activity) {

                $props = $activity?->toArray() ?? [];

                // Helper to resolve username
                $resolveUserName = function ($id, $fallback = 'Unknown') {
                    if (!$id) return $fallback;

                    $user = User::find($id);
                    return $user
                        ? trim($user->first_name . ' ' . $user->last_name)
                        : $fallback;
                };

                // Helper to resolve lead name
                $resolveLeadName = function ($id) {
                    if (!$id) return 'Unknown Lead';

                    $lead = Leads::find($id);
                    return $lead
                        ? trim($lead->first_name . ' ' . $lead->last_name)
                        : 'Unknown Lead';
                };

                /*
                |--------------------------------------------------------------------------
                | OLD VALUES (updated / deleted)
                |--------------------------------------------------------------------------
                */
                if (isset($props['properties']['old'])) {

                    // User
                    if (isset($props['properties']['old']['user_id'])) {
                        $props['properties']['old']['user_id'] =
                            $resolveUserName($props['properties']['old']['user_id'], 'System');
                    }

                    // Assigned Agent
                    if (isset($props['properties']['old']['assigned_agent'])) {
                        $props['properties']['old']['assigned_agent_name'] =
                            $resolveUserName($props['properties']['old']['assigned_agent'], 'Unassigned');
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | NEW VALUES (created / updated)
                |--------------------------------------------------------------------------
                */
                if (isset($props['properties']['attributes'])) {
                    // User
                    if (isset($props['properties']['attributes']['user_id'])) {
                        $props['properties']['attributes']['user_id'] =
                            $resolveUserName($props['properties']['attributes']['user_id'], 'System');
                    }

                    // Assigned Agent
                    if (isset($props['properties']['attributes']['assigned_agent'])) {
                        $props['properties']['attributes']['assigned_agent'] =
                            $resolveUserName($props['properties']['attributes']['assigned_agent'], 'Unassigned');
                    }
                }

                return $props;
            })
            ->addColumn('primary_text', function ($activity) {

                $causer = $activity->causer?->full_name ?? 'System';

                $verb = match ($activity->event) {
                    'created' => 'created',
                    'updated' => 'updated',
                    'deleted' => 'deleted',
                    'login' => 'login',
                    'logout' => 'logout',
                    default   => 'performed an action on',
                };

                // Normalize log name (appointments → appointment, notes → note)
                $subject = \Illuminate\Support\Str::singular(
                    str_replace('_', ' ', $activity->log_name)
                );

                // Article handling
                $article = in_array($subject[0], ['a','e','i','o','u']) ? 'an' : 'a';

                return $activity->event === 'login' || $activity->event === 'logout' ? "{$causer} {$activity->description}" : "{$causer} {$verb} {$article} {$subject}";
//                return "{$causer} {$verb} {$article} {$subject}";
            })
            ->make(true);
    }
}
