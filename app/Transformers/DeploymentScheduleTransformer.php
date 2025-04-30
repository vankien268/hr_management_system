<?php

namespace App\Transformers;

use App\Enums\SystemPermissionEnum;
use App\Models\DeploymentSchedule;
use App\Models\DeploymentScheduleDetail;
use League\Fractal\TransformerAbstract;

use function App\Helper\check_user_permission;

class DeploymentScheduleTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
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
    public function __construct($relation = false)
    {
        $this->relation = $relation;
    }
    public function transform(DeploymentSchedule $entry)
    {
        $data = [
            'id' =>  $entry->id,
            'code' =>  $entry->code,
            'title' =>  $entry->title,
            'project_id' =>  $entry->project_id,
            'from_date' =>  $entry->from_date,
            'to_date' =>  $entry->to_date,
            'note' =>  $entry->note,
            'status_id' =>  $entry->status_id,
            'contract_type_id' => $entry->contract_type_id,
            'is_edit' => $entry->created_by == auth()->user()->id || check_user_permission(SystemPermissionEnum::EDIT_DEPLOYMENT_SCHEDULE),
            'is_delete' => $entry->created_by == auth()->user()->id || check_user_permission(SystemPermissionEnum::DELETE_DEPLOYMENT_SCHEDULE),
            'project_content' => $entry->project_content
        ];

        if($this->relation) {
            $data['project'] = fractal($entry->project, new ProjectManagementTransformer());
            $data['projectNameAndCode'] = $entry->project->code . ' - ' . $entry->project->name;
            $data['users'] = fractal($entry->users, new UserTransformer(false, false, true));
            $data['deploymentScheduleDetails'] = fractal($entry->deploymentScheduleDetails, new DeploymentScheduleDetailTransformer());
            $data['status'] = fractal($entry->status, new SystemStatusTransformer());
            $data['contractType'] = fractal($entry->contractType, new ContractTypeTransformer());
        }
        return $data;
    }
}
