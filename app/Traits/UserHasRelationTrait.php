<?php
namespace App\Traits;

use App\Models\AcceptanceRecord;
use App\Models\AnnexContract;
use App\Models\Bank;
use App\Models\Contract;
use App\Models\ContractType;
use App\Models\Customer;
use App\Models\Department;
use App\Models\DeploymentRecord;
use App\Models\DeploymentSchedule;
use App\Models\Dispatch;
use App\Models\Product;
use App\Models\ProductGroup;
use App\Models\Project;
use App\Models\ProjectType;
use App\Models\Quote;
use App\Models\Role;
use App\Models\SystemStatus;
use App\Models\Task;
use App\Models\Unit;
use App\Models\User;

trait UserHasRelationTrait {

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_user')->withPivot(['note', 'status']);
    }
    public function projectsByUpdatedBy($byColumn = 'updated_by')
    {
        return $this->hasMany(Project::class, $byColumn);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function departments($byColumn = 'updated_by')
    {
        return $this->hasMany(Department::class, $byColumn);
    }

    public function banks($byColumn = 'updated_by')
    {
        return $this->hasMany(Bank::class, $byColumn);
    }

    public function customers($byColumn = 'updated_by')
    {
        return $this->hasMany(Customer::class, $byColumn);
    }

    public function contracts($byColumn = 'updated_by')
    {
        return $this->hasMany(Contract::class,  $byColumn);
    }

    public function systemStatuses($byColumn = 'updated_by')
    {
        return $this->hasMany(SystemStatus::class,  $byColumn);
    }

    public function projectTypes($byColumn = 'updated_by')
    {
        return $this->hasMany(ProjectType::class,  $byColumn);
    }

    public function contractTypes($byColumn = 'updated_by')
    {
        return $this->hasMany(ContractType::class,  $byColumn);
    }

    public function users($byColumn = 'updated_by')
    {
        return $this->hasMany(User::class,  $byColumn);
    }

    public function acceptanceRecords($byColumn = 'updated_by')
    {
        return $this->hasMany(AcceptanceRecord::class,  $byColumn);
    }

    public function annexContracts($byColumn = 'updated_by')
    {
        return $this->hasMany(AnnexContract::class,  $byColumn);
    }

    public function deploymentRecords($byColumn = 'updated_by')
    {
        return $this->hasMany(DeploymentRecord::class,  $byColumn);
    }

    public function deploymentSchedulesUpdatedBy($byColumn = 'updated_by')
    {
        return $this->hasMany(DeploymentSchedule::class,  $byColumn);
    }

    public function dispatches($byColumn = 'updated_by')
    {
        return $this->hasMany(Dispatch::class,  $byColumn);
    }

    public function products($byColumn = 'updated_by')
    {
        return $this->hasMany(Product::class,  $byColumn);
    }

    public function quotes($byColumn = 'updated_by')
    {
        return $this->hasMany(Quote::class,  $byColumn);
    }

    public function rolesByUpdatedBy($byColumn = 'updated_by')
    {
        return $this->hasMany(Role::class,  $byColumn);
    }

    public function tasks($byColumn = 'updated_by')
    {
        return $this->hasMany(Task::class,  $byColumn);
    }

    public function units($byColumn = 'updated_by')
    {
        return $this->hasMany(Unit::class,  $byColumn);
    }

    public function productGroups($byColumn = 'updated_by')
    {
        return $this->hasMany(ProductGroup::class,  $byColumn);
    }

    // Created by
    public function projectsByUpdatedByCreatedBy()
    {
        return $this->hasMany(Project::class, 'created_by');
    }

    public function departmentsCreatedBy()
    {
        return $this->hasMany(Department::class, 'created_by');
    }

    public function banksCreatedBy()
    {
        return $this->hasMany(Bank::class, 'created_by');
    }

    public function customersCreatedBy()
    {
        return $this->hasMany(Customer::class, 'created_by');
    }

    public function contractsCreatedBy()
    {
        return $this->hasMany(Contract::class,  'created_by');
    }

    public function systemStatusesCreatedBy()
    {
        return $this->hasMany(SystemStatus::class,  'created_by');
    }

    public function projectTypesCreatedBy()
    {
        return $this->hasMany(ProjectType::class,  'created_by');
    }

    public function contractTypesCreatedBy()
    {
        return $this->hasMany(ContractType::class,  'created_by');
    }

    public function usersCreatedBy()
    {
        return $this->hasMany(User::class,  'created_by');
    }

    public function acceptanceRecordsCreatedBy()
    {
        return $this->hasMany(AcceptanceRecord::class,  'created_by');
    }

    public function annexContractsCreatedBy()
    {
        return $this->hasMany(AnnexContract::class,  'created_by');
    }

    public function deploymentRecordsCreatedBy()
    {
        return $this->hasMany(DeploymentRecord::class,  'created_by');
    }

    public function deploymentSchedulesUpdatedByCreatedBy()
    {
        return $this->hasMany(DeploymentSchedule::class,  'created_by');
    }

    public function dispatchesCreatedBy()
    {
        return $this->hasMany(Dispatch::class,  'created_by');
    }

    public function productsCreatedBy()
    {
        return $this->hasMany(Product::class,  'created_by');
    }

    public function quotesCreatedBy()
    {
        return $this->hasMany(Quote::class,  'created_by');
    }

    public function rolesByUpdatedByCreatedBy()
    {
        return $this->hasMany(Role::class,  'created_by');
    }

    public function tasksCreatedBy()
    {
        return $this->hasMany(Task::class,  'created_by');
    }

    public function unitsCreatedBy()
    {
        return $this->hasMany(Unit::class,  'created_by');
    }

    public function productGroupsCreatedBy()
    {
        return $this->hasMany(ProductGroup::class,  'created_by');
    }
}
