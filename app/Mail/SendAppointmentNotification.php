<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendAppointmentNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $queue = 'emails';


    /**
     * Create a new message instance.
     */
    public function __construct(
        public $subject,
        public string $title,
        public Appointment $appointment
    )
    {
        $this->afterCommit();
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('noreply@johnkevinpaunel.com', 'John Kevin'),
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.appointment',
            with: ['appointment' => $this->appointment]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }

    public function failed(Throwable $e)
    {
        Log::error('Appointment email failed', [
            'error' => $e->getMessage(),
            'appointment_id' => $this->appointment->id
        ]);
    }
}
