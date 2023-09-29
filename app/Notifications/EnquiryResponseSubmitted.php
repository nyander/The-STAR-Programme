<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EnquiryResponseSubmitted extends Notification
{
    use Queueable;
    protected $response;
    protected $client;
    /**
     * Create a new notification instance.
     */
    public function __construct(public $responsedetails)
    {
        
        $this->response = $responsedetails;
        $this->client = $this->response->user;
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
            'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('AthleteRise by Star Mentality: '.$this->client->name.' has responded to an Enquiry')
            ->greeting('Hi, this is an email to inform you that '.$this->client->name.' has responded to the Enquiry '.$this->response->enquiry->subject.':')
            ->line('Enquiry: '.$this->response->enquiry->subject)
            ->line('Response: '.$this->response->response)
            ->line('Please head to the Enuquiry board page to review the response\'s response.')
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
            'data' => $this->client->name .' has responded to the Enquiry '. $this->response->enquiry->subject .'.',
        ];
    }
}
