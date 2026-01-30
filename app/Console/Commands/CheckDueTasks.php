<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Models\User;
use App\Notifications\TaskDueNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckDueTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:check-due';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify users of near-due or overdue assigned tasks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();

        $tasks = Task::query()
            ->whereNull('deleted_at')
            ->whereNotIn('status', ['completed'])
            ->whereNotNull('assigned_to')
            ->where('due_date', '<=', $now->copy()->addHours(1))
            ->get();

        foreach ($tasks as $task) {

            $type = $task->due_date->isPast()
                ? 'task_overdue'
                : 'task_near_due';

            if($task->due_date->isPast() && $task->status !== 'overdue')
            {
                $task->update(['status' => 'overdue']);
                $this->info('tasks');
            }

            // Prevent duplicate notifications
            $alreadyNotified = DB::table('notifications')
                ->where('type', TaskDueNotification::class)
                ->where('notifiable_id', $task->assigned_to)
                ->whereJsonContains('data->task_id', $task->id)
                ->whereJsonContains('data->type', $type)
                ->whereJsonContains(
                    'data->due_date',
                    $task->due_date->format('F d, Y | h:i A')
                )
                ->exists();

            if ($alreadyNotified) {
                continue;
            }


            $user = User::find($task->assigned_to);

            if (! $user) {
                continue;
            }

//            echo $task->due_date->toDateTimeString();

            $user->notify(new TaskDueNotification($task, $type, $type));

        }


    }
}
