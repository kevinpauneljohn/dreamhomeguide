<?php

namespace App\Notifications;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\App;

class AppointmentDueNotification extends Notification implements ShouldQueue, ShouldBroadcast
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Appointment $appointment,
        public string $reminderType,
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
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toDatabase($notifiable): array
    {
        $dateFormatted = Carbon::parse($this->appointment->appointment_date)
            ->format('F d, Y | h:i A');
        return [
            'title' => $this->reminderType === 'due_today'
                ? 'Appointment Due Today'
                : 'Appointment in 3 Days',
            'message' => $this->appointment->title,
            'appointment_id' => $this->appointment->id,
            'reminder_type' => $this->reminderType,
            'type' => $this->type,
            'appointment_date' => $this->appointment->appointment_date
                ->format('M d, Y h:i A'),
            'url' => route('appointment.show', $this->appointment->id),
            'description' =>
                'Appointment Date: ' . $dateFormatted .
                '<br/>' . ucwords($this->appointment->title) .
                '<br/>' . ucwords($this->appointment->appointment_type),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'title' => $this->reminderType === 'due_today'
                ? 'Appointment Due Today'
                : 'Appointment in 3 Days',
            'appointment_id' => $this->appointment->id,
            'reminder_type' => $this->reminderType,
            'type' => $this->type,
            'url' => route('appointment.show', $this->appointment->id),
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $dateFormatted = Carbon::parse($this->appointment->appointment_date)
            ->format('F d, Y | h:i A');

        return [
            'type' => 'appointment_' . $this->type, // due_today | due_in_3_days

            'appointment_id' => $this->appointment->id,
            'lead_id' => $this->appointment->lead_id,

            'lead_name' => optional($this->appointment->lead)->full_name,
            'assigned_agent' => optional($this->appointment->agent)->full_name,
            'created_by' => optional($this->appointment->user)->full_name,

            'appointment_type' => $this->appointment->appointment_type,

            'date' => $dateFormatted,

            'url' => route('appointment.show', [
                'appointment' => $this->appointment->id
            ]),

            'description' =>
                'Appointment Date: ' . $dateFormatted .
                '<br/>' . ucwords($this->appointment->appointment_type),
        ];
    }
}
