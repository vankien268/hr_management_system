<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Wildside\Userstamps\Userstamps;
use App\Traits\UserHasRelationTrait;
use Illuminate\Support\Facades\Cache;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, UserHasRelationTrait, Userstamps;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'email',
        'phone',
        'gender',
        'birthday',
        'status',
        'department_id',
        'login_number',
        'skype',
        'avatar'
    ];

    // protected $appends = ['permissions'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function isUserOnline($id)
    {
        return Cache::get('user-is-online-'.$id);
    }

    public function contractUserCharges()
    {
        return $this->hasMany(Contract::class, 'user_charge_id');
    }

    public function contractUserContractors()
    {
        return $this->hasMany(Contract::class, 'user_contractor_id');
    }

    public function deploymentSchedules()
    {
        return $this->belongsToMany(DeploymentSchedule::class, 'project_implementers');
    }

    public function projectFunctionUsers()
    {
        return $this->belongsToMany(SystemFunction::class, 'project_function_user')->withPivot(['user_id', 'project_id', 'system_function_id']);
    }

    public function userHasProjectPermisison()
    {
        return $this->hasMany(ProjectFunctionUser::class, 'user_id');
    }

    /**
     * Get all of the projectPermissions for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projectFunctionUser(): HasMany
    {
        return $this->hasMany(ProjectFunctionUser::class,);
    }

    public function resultUserHasRelated(User $user)
    {
        // updated by và có quan hệ đc thêm vào luồng trong khai báo
        if($user->projects->count()) {
            return false;

        }else if($user->departments->count()) {
            return false;

        }else if($user->banks->count()) {
            return false;

        }else if($user->customers->count()) {
            return false;

        }else if($user->contracts->count()) {
            return false;

        }else if($user->systemStatuses->count()) {
            return false;

        }else if($user->projectTypes->count()) {
            return false;

        }else if($user->contractTypes->count()) {
            return false;

        }else if($user->contractUserCharges->count()) {
            return false;

        }else if($user->contractUserContractors->count()) {
            return false;
        }else if($user->acceptanceRecords->count()) {
            return false;

        }else if($user->annexContracts->count()) {
            return false;

        }else if($user->deploymentRecords->count()) {
            return false;

        }else if($user->deploymentSchedulesUpdatedBy->count()) {
            return false;

        }else if($user->dispatches->count()) {
            return false;

        }else if($user->products->count()) {
            return false;

        }else if($user->quotes->count()) {
            return false;

        }else if($user->rolesByUpdatedBy->count()) {
            return false;

        }else if($user->tasks->count()) {
            return false;

        }else if($user->units->count()) {
            return false;

        }else if($user->productGroups->count()) {
            return false;
        }else if($user->users->count()) {
            return false;
        }
        // created by

        else if($user->projectsByUpdatedByCreatedBy->count()) {
            return false;

        }else if($user->departmentsCreatedBy->count()) {
            return false;

        }else if($user->banksCreatedBy->count()) {
            return false;

        }else if($user->customersCreatedBy->count()) {
            return false;

        }else if($user->contractsCreatedBy->count()) {
            return false;

        }else if($user->systemStatusesCreatedBy->count()) {
            return false;

        }else if($user->projectTypesCreatedBy->count()) {
            return false;

        }else if($user->contractTypesCreatedBy->count()) {
            return false;

        }else if($user->usersCreatedBy->count()) {
            return false;

        }else if($user->acceptanceRecordsCreatedBy->count()) {
            return false;

        }else if($user->annexContractsCreatedBy->count()) {
            return false;

        }else if($user->deploymentRecordsCreatedBy->count()) {
            return false;

        }else if($user->deploymentSchedulesUpdatedByCreatedBy->count()) {
            return false;

        }else if($user->deploymentSchedulesUpdatedBy->count()) {
            return false;

        }else if($user->dispatchesCreatedBy->count()) {
            return false;

        }else if($user->productsCreatedBy->count()) {
            return false;

        }else if($user->quotesCreatedBy->count()) {
            return false;

        }else if($user->rolesByUpdatedBy->count()) {
            return false;

        }else if($user->tasksCreatedBy->count()) {
            return false;

        }else if($user->unitsCreatedBy->count()) {
            return false;

        }else if($user->productGroupsCreatedBy->count()) {
            return false;
        }

        return true;
    }

    /**
     * The roles that belong to the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_users', 'user_id', 'role_id')->where('roles.status', true);
    }

    // public function getPermissionsAttribute () {
    //     // $role = $this->load('roles.roleSystemFunctions');
    //     // $permission = $role->roles->pluck('roleSystemFunctions.*.system_function_id')->unique();
    //     // $r = $permission->reduce(function ($result, $item) {
    //     //     return array_merge($result, $item);
    //     // }, []);
    //     return []; //$r;
    // }

}
