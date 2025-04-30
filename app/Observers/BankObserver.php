<?php

namespace App\Observers;

use App\Enums\SystemPermissionEnum;
use App\Models\Bank;

use function App\Helper\check_user_permission;

class BankObserver
{
    /**
     * Handle the Bank "created" event.
     */
    public function created(Bank $bank): void
    {
        //
    }

    /**
     * Handle the Bank "updated" event.
     */
    public function updated(Bank $bank): void
    {
        //
    }

    /**
     * Handle the Bank "deleting" event.
     */
    public function deleting(Bank $bank): bool
    {
        if ( ($bank->created_by == auth()->user()->id || check_user_permission(SystemPermissionEnum::DELETE_BANK)) && !$bank->customer) {
            return true;
        }
        return false;
    }

    /**
     * Handle the Bank "deleted" event.
     */
    public function deleted(Bank $bank): void
    {
        //
    }

    /**
     * Handle the Bank "restored" event.
     */
    public function restored(Bank $bank): void
    {
        //
    }

    /**
     * Handle the Bank "force deleted" event.
     */
    public function forceDeleted(Bank $bank): void
    {
        //
    }
}
