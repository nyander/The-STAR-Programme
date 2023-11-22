<?php

namespace App\Notifications;

use App\Models\PerformanceProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PerformanceProfileSubmitted extends Notification
{
    use Queueable;
    protected $pProfile;
    protected $client;

    /**
     * Create a new notification instance.
     */
    public function __construct(public PerformanceProfile $performanceProfile)
    {
        $this->pProfile = $performanceProfile;
        $this->client = $performanceProfile->client;
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
        ->subject("New Performance Profile from {$this->client->name}")
        ->greeting("New Performance Profile from {$this->client->name}")
        ->action('Go to the Performance profile', url('/'))
        ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'data' => $this->pProfile->client->name .' has submitted a new Performance Profile. Please Review.',
            'performanceProfile' => $this->pProfile,
        ];
    }
}
