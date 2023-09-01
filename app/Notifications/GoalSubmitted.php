<?php

namespace App\Notifications;

use App\Models\ClientGoal;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GoalSubmitted extends Notification
{
    use Queueable;
    protected $goal;
    protected $practitioner;

    /**
     * Create a new notification instance.
     */
    public function __construct(ClientGoal $clientGoal, User $practitioner)
    {
        $this->goal = $clientGoal;
        $this->practitioner = $practitioner;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
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
            'data' => 'Practitioner '. $this->practitioner->name .' has submitted a new Goal - '. $this->goal->description.'.',
        ];
    }
}
