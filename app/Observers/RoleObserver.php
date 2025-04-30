<?php

namespace App\Observers;

use App\Models\Role;
use App\Models\RoleSystemFunction;
use App\Repositories\Interfaces\IRoleRepository;

class RoleObserver
{
    protected $roleRepository;
    public function __construct(IRoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }
    /**
     * Handle the Role "created" event.
     */
    public function created(Role $role): void
    {
        //
    }

    /**
     * Handle the Role "updated" event.
     */
    public function updated(Role $role): void
    {
        //
    }

    /**
     * Handle the Role "deleting" event.
     */
    public function deleting(Role $role): void
    {
        $systemFunction = $role->roleSystemFunctions;
        if($systemFunction->count() > 0){
            dd(2);
            RoleSystemFunction::where('role_id', $role->id)->delete();
            // $this->roleRepository->destroy($systemFunction->pluck('id')->toArray());
        }

    }

    /**
     * Handle the Role "deleted" event.
     */
    public function deleted(Role $role): void
    {
        //
    }

    /**
     * Handle the Role "restored" event.
     */
    public function restored(Role $role): void
    {
        //
    }

    /**
     * Handle the Role "force deleted" event.
     */
    public function forceDeleted(Role $role): void
    {
        //
    }
}
