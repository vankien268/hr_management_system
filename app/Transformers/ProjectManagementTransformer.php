<?php

namespace App\Transformers;

use App\Enums\ProjectPermissionEnum;
use App\Enums\SystemFunctionEnum;
use App\Enums\SystemPermissionEnum;
use App\Models\Project;
use App\Transformers\ContactTransformer;
use League\Fractal\TransformerAbstract;
use function App\Helper\check_user_permission;

class ProjectManagementTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [

    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    protected $relation = false;
    protected $isDelete = false;
    protected $projectPermission = false;

    public function __construct($relation = false, $isDelete = false, $projectPermission = false)
    {
        $this->relation = $relation;
        $this->isDelete = $isDelete;
        $this->projectPermission = $projectPermission;
    }

    public function transform(Project $entry)
    {
        $data = [
            'id' => $entry->id,
            'code' => $entry->code,
            'name' => $entry->name,
            'city_id' =>  $entry->city_id,
            'project_type_id' => $entry->project_type_id,
            'customer_id' => $entry->customer_id,
            'status_id' => $entry->status_id,
            'description' => $entry->description,
            'note' => $entry->note,
            'created_at' => $entry->created_at ? $entry->created_at->format('d/m/Y') : '',
            'functions' => $entry->functions,
            'canPermissionEditProject' => $entry->checkUserHasProjectPermission(
                ProjectPermissionEnum::EDIT_PROJECT, $entry->id
            ),
            'canPermissionAddContract' => $entry->checkUserHasProjectPermission(
                ProjectPermissionEnum::ADD_CONTRACT, $entry->id
            ),
            'canEditPermissionSystem' => check_user_permission(SystemPermissionEnum::SYSTEM_EDIT_PROJECT),
            'canDeletePermissionSystem' => (check_user_permission(SystemPermissionEnum::SYSTEM_DELETE_PROJECT) || auth()->user()->id == $entry->created_by),
            'canUserCreateProject' => ($entry->checkUserCreate($entry->created_by) || check_user_permission(SystemPermissionEnum::SYSTEM_DECENTRALIZATION_PROJECT)),
            'userIdCreator' => $entry->created_by,
            'customer' => fractal($entry->customer, new CustomerTransformer())
        ];

        if($this->relation) {
            $data['customer'] = fractal($entry->customer, new CustomerTransformer());
            $data['systemStatus'] = fractal($entry->statusProject, new SystemStatusTransformer());
            $data['city'] = fractal($entry->city, new CityTransformer());
            $data['users'] = fractal($entry->users, new UserTransformer(true, false, true));
            $data['projectType'] = fractal($entry->projectType, new ProjectTypeTransformer());
            $data['contacts'] = fractal($entry->contacts, new ContactTransformer(true, false, $entry->id));
            $data['tasks'] = fractal($entry->tasks, new TaskTransformer(true));
            $data['contracts'] = fractal($entry->contracts, new ContractTransformer());
            $data['userCurrent'] = auth()->user()->name;
            $data['user_id'] = auth()->user()->id;
            $data['projectFunctionUsers'] = $entry->projectFunctionUsers;
        }
        if($this->isDelete) {
            $data['isDelete'] = true;
            $entry->load('contracts');
            if($entry->contracts->count()) {
                $data['isDelete'] = false;
            }
            if($entry->deploymentSchedules->count()) {
                $data['isDelete'] = false;
            }
        }
        // if($this->projectPermission) {
        //     $data['userHasProjectPermission'] = $entry->userPermissions();
        // }
        return $data;
    }
}
