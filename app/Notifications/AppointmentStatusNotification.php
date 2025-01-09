<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AppointmentStatusNotification extends Notification
{
    use Queueable;

    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
                    ->subject('Appointment Status Update')
                    ->line($this->details['message'])
                    ->line('Date: ' . $this->details['appointment_date'])
                    ->line('Doctor: ' . $this->details['doctor'])
                    ->line('Status: ' . $this->details['status']);
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->details['message'],
            'appointment_date' => $this->details['appointment_date'],
            'doctor' => $this->details['doctor'],
            'status' => $this->details['status'],
        ];
    }
}
