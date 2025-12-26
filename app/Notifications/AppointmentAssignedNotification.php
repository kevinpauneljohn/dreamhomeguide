<?php

namespace App\Notifications;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentAssignedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Appointment $appointment,
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
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Appointment Notification')
            ->greeting('Good day!')
            ->line(match ($this->type) {
                'created'  => 'A new appointment has been created.',
                'assigned' => 'You have been assigned a new appointment.',
                default    => 'An appointment has been updated.',
            })
            ->line('Client: ' . $this->appointment->lead->full_name)
            ->line('Date: ' . Carbon::parse($this->appointment->appointment_date)->format('F d, Y | h:i A'))
            ->line('Location: ' . $this->appointment->location)
            ->line('Assigned Agent: ' . $this->appointment->agent->full_name)
            ->line('Created By: ' . $this->appointment->user->full_name)
            ->action(
                'View Appointment',
                url('/appointment/' . $this->appointment->id. '?notification=read&id='.$this->id)
            );
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'appointment_' . $this->type,
            'appointment_id' => $this->appointment->id,
            'lead_id' => $this->appointment->lead_id,
            'lead_name' => $this->appointment->lead->full_name,
            'assigned_agent' => $this->appointment->agent->full_name,
            'created_by' => $this->appointment->user->full_name,
            'appointment_type' => $this->appointment->appointment_type,
            'date' => Carbon::parse($this->appointment->appointment_date)->format('F d, Y | h:i A'),
            'url' => url('/appointment/' . $this->appointment->id),
            'description' => 'Appointment Date: '.Carbon::parse($this->appointment->appointment_date)->format('F d, Y | h:i A')
                .'<br/>'.ucwords($this->appointment->appointment_type)
        ];
    }
}
