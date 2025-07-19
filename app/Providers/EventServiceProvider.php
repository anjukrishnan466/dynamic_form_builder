<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
   public function boot()
{
    // When a job is successfully processed
    Event::listen(JobProcessed::class, function ($event) {
        Log::info("Job processed: " . $event->job->resolveName());
    });

    // When a job fails
    Event::listen(JobFailed::class, function ($event) {
        Log::error("Job failed: " . $event->job->resolveName());
        Log::error("Error: " . $event->exception->getMessage());
    });
}

}
