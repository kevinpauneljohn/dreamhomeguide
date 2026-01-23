<?php

namespace App\Notifications;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskDueNotification extends Notification implements ShouldQueue, shouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Task $task,
        public string $reminderType, // due_today | due_soon | overdue
        public string $type // near_due | overdue
    )
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('You have a task reminder.')
            ->action('View Task', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toDatabase(object $notifiable): array
    {
        $dateFormatted = Carbon::parse($this->task->due_date)
            ->format('F d, Y | h:i A');

        return [
            'title' => match ($this->type) {
                'due_today' => 'Task Due Today',
                'overdue'   => 'Task Overdue',
                default     => 'Task Due Soon',
            },

            'message' => $this->task->title,

            'task_id' => $this->task->id,
            'type'    => $this->type,

            'due_date' => $dateFormatted,

            'url' => route('task.show', $this->task->id),

            'description' =>
                'Due Date: ' . $dateFormatted .
                '<br/>' . ucwords($this->task->title) .
                '<br/>Priority: ' . ucfirst($this->task->priority),
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'title' => match ($this->reminderType) {
                'due_today' => 'Task Due Today',
                'overdue'   => 'Task Overdue',
                default     => 'Task Due Soon',
            },

            'task_id' => $this->task->id,
            'type' => $this->type,
            'url' => route('task.show', $this->task->id),
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $dateFormatted = Carbon::parse($this->task->due_date)
            ->format('F d, Y | h:i A');

        return [
            'type' => 'task_' . $this->type, // task_due_today | task_due_soon | task_overdue

            'task_id' => $this->task->id,
            'lead_id' => $this->task->lead_id,

            'assigned_to' => optional($this->task->assignedUser)->full_name,
            'created_by'  => optional($this->task->user)->full_name,

            'priority' => $this->task->priority,
            'status'   => $this->task->status,

            'date' => $dateFormatted,

            'url' => route('task.show', [
                'task' => $this->task->id
            ]),

            'description' =>
                'Due Date: ' . $dateFormatted .
                '<br/>' . ucwords($this->task->title),
        ];
    }
}
