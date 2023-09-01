<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Channels\DatabaseChannel;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MissingPerformanceProfile extends Notification
{
    use Queueable;
    private $clients;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $clients)
    {
        $this->clients = collect($clients);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', DatabaseChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $clientCount = $this->clients->count();
        $clientNames = $this->clients->map(function ($client) {
            return "- {$client['name']} - {$client['email']}";
        })->implode("\n");

        return (new MailMessage)
            ->subject('STAR Program: Clients missing Performance Profiles')
            ->greeting("Hi, there are {$clientCount} clients who have not submitted Performance Profiles for over 7 days.")
            ->line("Please get in touch with the following clients:")
            ->line($clientNames)
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
        $clientCount = $this->clients->count();
        $message = "You have {$clientCount} client(s) who have not submitted Performance Profiles for over 7 days. Please get in touch with them.";

        return [
            'data' => $message,
        ];
    }
}
