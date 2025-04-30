<?php

namespace App\Observers;

use App\Models\SystemStatus;

class SystemStatusObserver
{
    /**
     * Handle the SystemStatus "created" event.
     */
    public function created(SystemStatus $systemStatus): void
    {
        //
    }

    /**
     * Handle the SystemStatus "updated" event.
     */
    public function updated(SystemStatus $systemStatus): void
    {
        //
    }

    /**
     * Handle the SystemStatus "deleting" event.
     */
    public function deleting(SystemStatus $systemStatus): bool
    {
        if (
            $systemStatus->contracts->count() > 0 ||
            $systemStatus->projects->count() > 0 ||
            $systemStatus->customers->count() > 0 ||
            $systemStatus->tasks->count() > 0 ||
            $systemStatus->acceptanceRecords->count() > 0 ||
            $systemStatus->deploymentRecords->count() > 0 ||
            $systemStatus->deploymentSchedules->count() > 0 ||
            $systemStatus->dispatches->count() > 0
        ) {
            return false;
        }
        return true;
    }

    /**
     * Handle the SystemStatus "deleted" event.
     */
    public function deleted(SystemStatus $systemStatus): void
    {
        //
    }

    /**
     * Handle the SystemStatus "restored" event.
     */
    public function restored(SystemStatus $systemStatus): void
    {
        //
    }

    /**
     * Handle the SystemStatus "force deleted" event.
     */
    public function forceDeleted(SystemStatus $systemStatus): void
    {
        //
    }
}
