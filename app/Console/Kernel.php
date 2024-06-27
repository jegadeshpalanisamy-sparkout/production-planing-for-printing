<?php

namespace App\Console;

use App\Jobs\SendPendingWorkEmailsJob;
use App\Models\OrderProcess;
use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        $schedule->call(function(){
            $employees=User::all();

            foreach ($employees as $employee) {
                $pendingWorks=OrderProcess::where('employee_id',$employee->id)->whereNull('end_time')->get();
                if ($pendingWorks->isNotEmpty()) {
                    SendPendingWorkEmailsJob::dispatch($employee, $pendingWorks);
                }
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
