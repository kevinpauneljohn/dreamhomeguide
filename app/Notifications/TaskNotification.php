<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskNotification extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Task $task,
        public string $type
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
        return ['database','broadcast'];
    }

    public function toBroadcast(object $notifiable): array
    {
        return [
            'id'          => $this->id,
            'type'        => 'task.created',
            'task_number'  => $this->task->id,               // ✅ ADD THIS
            'title'        => "Task #{$this->task->id}",
            'message'     => $this->task->title,
            'task_id'     => $this->task->id,
            'priority'    => $this->task->priority,
            'status'      => $this->task->status,
            'due_date'    => optional($this->task->due_date)->toDateTimeString(),
            'url'         => route('task.show', $this->task->id),
            'created_at'  => now()->toDateTimeString(),
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("New Task Assigned – Task #{$this->task->id}")
            ->greeting("Hello {$notifiable->name},")
            ->line("You have been assigned a new task.")
            ->line("Task Number: Task #{$this->task->id}")
            ->line("Title: {$this->task->title}")
            ->line("Priority: " . ucfirst($this->task->priority))
            ->line(
                $this->task->due_date
                    ? "Due Date: {$this->task->due_date->format('M d, Y h:i A')}"
                    : "Due Date: Not specified"
            )
            ->action(
                'View Task',
                route('task.show', $this->task->id)
            )
            ->line('Please attend to this task as soon as possible.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'task_'. $this->type,
            'title' => "Task #{$this->task->id}",
            'description' =>
                "Title: {$this->task->title}<br>" .
                "Priority: " . ucfirst($this->task->priority),
            'url' => route('task.show', $this->task->id),
        ];
    }

}
