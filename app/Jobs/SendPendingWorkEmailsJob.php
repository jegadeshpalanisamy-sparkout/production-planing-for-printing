<?php

namespace App\Jobs;

use App\Mail\PendingWorkMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendPendingWorkEmailsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $employee;
    public $pendingWorks;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($employee,$pendingWorks)
    {
        //
        $this->employee=$employee;
        $this->pendingWorks=$pendingWorks;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->employee->email)->send(new PendingWorkMail($this->employee,$this->pendingWorks));
    }
}
