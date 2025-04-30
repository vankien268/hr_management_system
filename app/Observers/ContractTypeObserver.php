<?php

namespace App\Observers;

use App\Models\ContractType;

class ContractTypeObserver
{
    /**
     * Handle the ContractType "created" event.
     */
    public function created(ContractType $contractType): void
    {
        //
    }

    /**
     * Handle the ContractType "updated" event.
     */
    public function updated(ContractType $contractType): void
    {
        //
    }

    /**
     * Handle the ContractType "deleting" event.
     */
    public function deleting(ContractType $contractType): bool
    {
        $contractType = $contractType->load('contracts');
        if(!$contractType->contracts->isEmpty()){
            return false;
        }
        return true;
    }

    /**
     * Handle the ContractType "deleted" event.
     */
    public function deleted(ContractType $contractType): void
    {
        //
    }

    /**
     * Handle the ContractType "restored" event.
     */
    public function restored(ContractType $contractType): void
    {
        //
    }

    /**
     * Handle the ContractType "force deleted" event.
     */
    public function forceDeleted(ContractType $contractType): void
    {
        //
    }
}
