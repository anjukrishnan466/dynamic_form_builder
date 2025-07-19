<?php

namespace App\Jobs;

use App\Mail\FormCreatedMail;
use App\Models\Form;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Auth;
use App\Models\FormMailLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class SendFormCreatedNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $form;
    public $email;

    public function __construct(Form $form, string $email)
    {
        $this->form = $form;
        $this->email = $email;
    }


    public function handle()
    {
        try {
            Mail::to($this->email)->send(new FormCreatedMail($this->form));
            $log = new FormMailLog([
                'form_id' => $this->form->id,
                'email' => $this->email,
                'status' => 'success',
                'error' => null,
            ]);
            $log->save();
        } catch (\Throwable $e) {
            FormMailLog::create([
                'form_id' => $this->form->id,
                'email' => $this->email,
                'status' => 'failed',
                'error' => $e->getMessage(),

            ]);

            Log::error('Email send failed: ' . $e->getMessage());
        }
    }
}
