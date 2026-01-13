<?php

namespace App\Notifications;

use App\Models\Leads;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class OrganicLeadCreated extends Notification implements ShouldQueue, ShouldBroadcast
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
        return ['database','broadcast'];
    }

    public function toBroadcast(object $notifiable): array
    {
        return [
            'id' => $this->id, // notification UUID
            'type' => 'organic_lead_created',
            'title' => 'New Organic Lead',
            'message' => $this->lead->full_name,
            'url' => route('leads.show',[
                'lead' => $this->lead->id,
                'notification' => 'read',
                'id' => $this->id
            ]),
            'created_at' => now()->toDateTimeString(),
        ];
    }


    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $lead = $this->lead->fresh('property');
        $message = trim(preg_replace("/\r\n|\r|\n/", "\n", $lead->message));
        $property = $lead->property;

        $propertyHtml = $property
            ? '<a href="' . route('property.show', $property->id) . '">' . e(ucwords($property->title)) . '</a>'
            : '<em>No property specified</em>';

        return (new MailMessage)
            ->subject('New Lead Received')
            ->greeting('Good day!')
            ->line('A new lead has been created in the system.')
            ->line('Name: ' . $lead->full_name)
            ->line('Email: ' . $lead->email)
            ->line('Contact: ' . $lead->phone)
            ->line('Source: ' . $lead->source)
            ->line(new HtmlString('<strong>Property Interested:</strong><br>' . $propertyHtml))
            ->line(new HtmlString('<strong>Message:</strong><br>' . nl2br(e($message))))
            ->action('View Lead', route('leads.show',[
                'lead' => $this->lead->id,
                'notification' => 'read',
                'id' => $this->id
            ]))
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
            'url'       => route('leads.show',[
                'lead' => $this->lead->id,
                'notification' => 'read',
                'id' => $this->id
            ]),
            'property'       => url('/property/' . $this->lead->property_id),
            'description' => 'Client: '.$this->lead->full_name.'<br/> '.substr($this->lead->message, 0, 30) . '...'
        ];
    }
}
