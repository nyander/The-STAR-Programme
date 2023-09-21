<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompletedContractAgreement extends Notification
{
    use Queueable;
    private $client;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $client)
    {
        $this->client = $client;
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
            ->subject("AthleteRise by Star Mentality: {$this->client->name} has Completed Agreed Contract")
            ->greeting("Hi, {$this->client->name} has completed their final performance profile thus completing their Agreed Program Contract")
            ->line("Please head to the client's profile to provide their final performance profile.")
            ->action('Go to the S.T.A.R Program App', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $message = " {$this->client->name} has completed their final performance profile thus completing their Agreed Program Contract";

        return [
            'data' => $message,
        ];
    }
}
