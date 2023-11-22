<?php

namespace App\Listeners;

use App\Events\PerformanceProfileCreated;
use App\Models\User;
use App\Notifications\NewPerformanceProfile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPerformanceProfileNotifications implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PerformanceProfileCreated $event): void
    {
        foreach (User::where('id', $event->performanceProfileTemplate->user_id)->cursor() as $user) {
            $user->notify(new NewPerformanceProfile($event->performanceProfileTemplate));
        }
    }
}
