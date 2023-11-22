<?php

namespace App\Console;

use App\Models\User;
use App\Notifications\FillPerformanceProfile;
use App\Notifications\MissingPerformanceProfile;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $clients = User::whereHas('roles', function ($query) {
                $query->where('name', 'client');
            })
            ->whereDoesntHave('roles', function ($query) {
                $query->where('name', '<>', 'client');
            })
            ->get();
            $practitioners = User::role('Admin')->get();
            $overdueClients = [];

            foreach($clients as $client) {
                $lastSubmittedProfile = $client->performanceProfile()->latest('created_at')->first();
                $countOfPerformanceProfiles = $client->performanceProfile->count();
                $clientAgreedSessions = $client->clientAgreement->program_duration;

                if ($lastSubmittedProfile && $countOfPerformanceProfiles < $clientAgreedSessions){
                    $daysSinceLastSubmission = now()->diffInDays($lastSubmittedProfile->created_at);
                    if($daysSinceLastSubmission > 7){
                        $overdueClients[] = $client;
                    }
                }
            }

            foreach($practitioners as $practitioner){
                $practitioner->notify(new MissingPerformanceProfile($overdueClients));
            }
       })->dailyAt('06:00');

       $schedule->call(function () {
            $clients = User::whereHas('roles', function ($query) {
                $query->where('name', 'client');
            })
            ->whereDoesntHave('roles', function ($query) {
                $query->where('name', '<>', 'client');
            })
            ->get();

            $today = Carbon::today()->format('l');
            foreach($clients as $client){
                if($client->clientAgreement->preferred_days == $today){
                    $client->notify(new FillPerformanceProfile());
                }
            }
       })->dailyAt('08:00');


    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
