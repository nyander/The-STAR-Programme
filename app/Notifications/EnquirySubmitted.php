<?php

namespace App\Notifications;

use App\Models\ClientEnquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EnquirySubmitted extends Notification
{
    use Queueable;
    protected $enquiry;
    protected $client;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $enquiryDetails)
    {
        $this->enquiry = $enquiryDetails;
        $this->client = $this->enquiry->client;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [
            // 'mail', 
            'database'
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject('AthleteRise by Star Mentality: '.$this->client->name.' has Submitted a new Enquiry')
        ->greeting('Hi, this is an email to inform you that '.$this->client->name.' has submitted a new enquiry:')
        ->line('Enquiry: '.$this->enquiry->content)
        ->line('Please head to the Message Board page to review the enquiry\'s enquiry.')
        ->action('Go to AthleteRise by Star Mentality', url('/enquiries'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'data' => $this->client->name.' has submitted an Enquiry. Please head to Message Board section'
        ];
    }
}
