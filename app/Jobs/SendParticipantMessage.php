<?php

namespace App\Jobs;

use App\Mail\ParticipantMessageEmail;
use App\ParticipantMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;

/**
 * Class SendParticipantMessage
 * @package App\Jobs
 */
class SendParticipantMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;

    }/**
     * Create a new job instance.
     *
     * @return void
     */


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send(new ParticipantMessageEmail($this->message));
    }
}
