<?php

namespace App\Listeners;

use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Log;

class LogMailFailure
{
    /**
     * Handle the event.
     *
     * @param  JobFailed  $event
     * @return void
     */
    public function handle(JobFailed $event)
    {
        Log::error('Queued job failed.', [
            'job'       => $event->job->resolveName(),
            'queue'     => $event->job->getQueue(),
            'payload'   => $event->job->payload(),
            'exception' => $event->exception->getMessage(),
        ]);
    }
}
