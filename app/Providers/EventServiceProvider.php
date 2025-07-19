<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

// Import these to handle job events
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Log;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        // Register listener class for job failures
        JobFailed::class => [
            \App\Listeners\LogMailFailure::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        parent::boot();

        //  Log successful job processing
        Event::listen(JobProcessed::class, function ($event) {
            Log::info("Job processed: " . $event->job->resolveName());
        });

        //  Log failed jobs (additional to the listener above)
        Event::listen(JobFailed::class, function ($event) {
            Log::error("Job failed: " . $event->job->resolveName());
            Log::error("Error: " . $event->exception->getMessage());
        });
    }
}
