<?php

namespace App\Notifications;

use App\Models\Leads;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class OrganicLeadCreated extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Leads $lead,
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
        $message = trim(preg_replace("/\r\n|\r|\n/", "\n", $this->lead->message));
        return (new MailMessage)
            ->subject('New Lead Received')
            ->greeting('Good day!')
            ->line('A new lead has been created in the system.')
            ->line('Name: ' . $this->lead->full_name)
            ->line('Email: ' . $this->lead->email)
            ->line('Contact: ' . $this->lead->phone)
            ->line('Source: ' . $this->lead->source)
            ->line(new HtmlString(
                '<strong>Message:</strong><br>' . nl2br(e($message))
            ))
            ->action(
                'View Lead',
                url('/leads/' . $this->lead->id)
            )
            ->line('Please follow up as soon as possible.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type'      => 'organic_lead_created',
            'lead_id'   => $this->lead->id,
            'name'      => $this->lead->full_name,
            'email'     => $this->lead->email,
            'phone'     => $this->lead->phone,
            'source'    => $this->lead->source,
            'message'   => $this->lead->message,
            'url'       => url('/leads/' . $this->lead->id),
        ];
    }
}
