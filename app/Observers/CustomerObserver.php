<?php

namespace App\Observers;

use App\Models\Customer;
use Spatie\Activitylog\Models\Activity;

class CustomerObserver
{
    /**
     * Handle the Customer "created" event.
     */
    public function created(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "updated" event.
     */
    public function updated(Customer $customer): void
    {
        Activity::all()->last();
    }

    /**
     * Handle the Customer "deleted" event.
     */
    public function deleted(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "deleting" event.
     */
    public function deleting(Customer $customer): bool
    {
        $customer = $customer->load(['contracts', 'projects']);
        if($customer->contracts->count() > 0 || $customer->projects->count() > 0){
            $delete = false;
        }
        return true;
    }

    /**
     * Handle the Customer "restored" event.
     */
    public function restored(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "force deleted" event.
     */
    public function forceDeleted(Customer $customer): void
    {
        //
    }
}
