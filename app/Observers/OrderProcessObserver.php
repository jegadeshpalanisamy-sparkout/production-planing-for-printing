<?php

namespace App\Observers;

use App\Models\OrderProcess;
use App\Models\User;
use App\Notifications\WorkAssignNotification;

class OrderProcessObserver
{
    /**
     * Handle the OrderProcess "created" event.
     *
     * @param  \App\Models\OrderProcess  $orderProcess
     * @return void
     */
    public function created(OrderProcess $orderProcess)
    {
        //

    }

    /**
     * Handle the OrderProcess "updated" event.
     *
     * @param  \App\Models\OrderProcess  $orderProcess
     * @return void
     */
    public function updated(OrderProcess $orderProcess)
    {
        //
        // $getEmployee=$orderProcess->employee_id;
        // dd($getEmployee);

        if($orderProcess->isDirty('employee_id'))
        {
            $employee=User::find($orderProcess->employee_id);
            if($employee)
            {
                $employee->notify(new WorkAssignNotification($orderProcess));
            }
        }

    }

    /**
     * Handle the OrderProcess "deleted" event.
     *
     * @param  \App\Models\OrderProcess  $orderProcess
     * @return void
     */
    public function deleted(OrderProcess $orderProcess)
    {
        //
        

    }

    /**
     * Handle the OrderProcess "restored" event.
     *
     * @param  \App\Models\OrderProcess  $orderProcess
     * @return void
     */
    public function restored(OrderProcess $orderProcess)
    {
        //
    }

    /**
     * Handle the OrderProcess "force deleted" event.
     *
     * @param  \App\Models\OrderProcess  $orderProcess
     * @return void
     */
    public function forceDeleted(OrderProcess $orderProcess)
    {
        //
    }
}
