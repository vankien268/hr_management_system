<?php

namespace App\Repositories;

use App\Enums\StatusEnum;
use App\Models\User;
use App\Repositories\Interfaces\IUserRepository;

class UserRepository extends BaseRepository implements IUserRepository {
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    const ARRAY_RELATIONSHIP = [
        'department',
        'projectsByUpdatedBy',
        'projects',
        'departments',
        'banks',
        'customers',
        'contracts',
        'systemStatuses',
        'projectTypes',
        'contractTypes',
        'users',
        'contractUserCharges',
        'contractUserContractors',
        'deploymentSchedules',
        'acceptanceRecords',
        'annexContracts',
        'deploymentRecords',
        'deploymentSchedulesUpdatedBy',
        'dispatches',
        'products',
        'quotes',
        'rolesByUpdatedBy',
        'tasks',
        'units',
        'productGroups',

        //created by
        'projectsByUpdatedByCreatedBy',
        'departmentsCreatedBy',
        'banksCreatedBy',
        'customersCreatedBy',
        'contractsCreatedBy',
        'systemStatusesCreatedBy',
        'projectTypesCreatedBy',
        'contractTypesCreatedBy',
        'usersCreatedBy',
        'acceptanceRecordsCreatedBy',
        'annexContractsCreatedBy',
        'deploymentRecordsCreatedBy',
        'deploymentSchedulesUpdatedByCreatedBy',
        'dispatchesCreatedBy',
        'productsCreatedBy',
        'quotesCreatedBy',
        'tasksCreatedBy',
        'unitsCreatedBy',
        'rolesByUpdatedByCreatedBy',
        'productGroupsCreatedBy'
    ];

    public function getDataFilter($request)
    {
        $department_value = $request['department_id'];
        $status = $request['status_id'];
        $usernameId = $request['username_id'];
        $userId = $request['user_id'];
        $arrayType = ["null", null];
        $users = $this->model->with(self::ARRAY_RELATIONSHIP)
            ->when( !in_array($department_value,$arrayType) ,function ($query) use ($department_value){
                return $query->where('department_id','like', $department_value);

        })->when(!in_array($status, $arrayType), function ($query) use ($status){
                return $query->where('status','like',$status);
        })
        ->when(!in_array($usernameId, $arrayType), function ($query) use ($usernameId){
                return $query->where('id', $usernameId);

        })->when( !in_array($userId, $arrayType), function ($query) use ($userId){
                return $query->where('id', $userId);
        });

        return $users;
    }

    public function getListUser()
    {
        return $result = $this->model->with(self::ARRAY_RELATIONSHIP)->where('status', StatusEnum::USING);
    }
}
