<?php

namespace App\Observers;

use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskNotification;


class TaskObserver
{
    /**
     * Handle the Task "created" event.
     */
    public function created(Task $task): void
    {
        // Notify assigned user only
        if (!$task->assigned_to) {
            return;
        }

        $user = User::find($task->assigned_to);

        if (!$user) {
            return;
        }

        $user->notify(new TaskNotification($task, 'created'));
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        /// Example: status changed to completed
        if ($task->wasChanged('status') && $task->status === 'completed') {
            // future: TaskCompletedNotification
        }

        // Example: reassigned
        if ($task->wasChanged('assigned_to')) {
            $newUser = User::find($task->assigned_to);

            if ($newUser) {
                $newUser->notify(new TaskNotification($task, 'Updated'));
            }
        }
    }

    /**
     * Handle the Task "deleted" event.
     */
    public function deleted(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "restored" event.
     */
    public function restored(Task $task): void
    {
        //
    }

    /**
     * Handle the Task "force deleted" event.
     */
    public function forceDeleted(Task $task): void
    {
        //
    }
}
