<?php

namespace App\Notifications;

use App\Models\PerformanceProfileTemplate;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPerformanceProfile extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public PerformanceProfileTemplate $performanceProfileTemplate)
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
                    ->subject("New Performance Profile from {$this->performanceProfileTemplate->user->name}")
                    ->greeting("New Performance Profile from {$this->performanceProfileTemplate->user->name}")
                    ->line(Str::limit($this->performanceProfileTemplate->title))
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
        $message = "New Performance Profile from {$this->performanceProfileTemplate->user->name}";

        return [
            'data' => $message,
        ];
    }
}
