<?php

namespace App\Transformers;

use App\Models\workflow;
use Illuminate\Support\Facades\DB;
use League\Fractal\TransformerAbstract;

class workflowTransformer extends TransformerAbstract
{
    private $users = [];

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
    public function transform(workflow $entry)
    {
        if(! $this->users) {
            $this->users = DB::table('users')->get()->keyBy('id');
        }

        $approverIds = $entry->approver_ids ? explode(',',$entry->approver_ids) : [];

        $users = [];
        $userApprovers = [];

        # user duyệt
        if($entry->approver_type == "user") {
            foreach ($approverIds as $approverId) {
                $user = $this->users[$approverId] ?? null;

                if($user == null) {
                    continue;
                }

                $users[] = [
                  'id' =>  $user->id,
                  'name' => $user->name,
                  'username' => $user->username,
                  'email' => $user->email,
                  'phone' => $user->phone,
                ];

                $userApprovers[] =  $user->name;
            }
        }else {
            # phòng ban duyệt
            if($entry->approver_type == "dept") {

                $departmentIds = $approverIds;

                foreach ($this->users  as $user) {
                    if(in_array($user->department_id,$departmentIds )) {
                        $userApprovers[] = $user->name;
                    }
                }
            }
        }

        $data = [
            'id' => $entry->id,
            'workflow_code' => $entry->workflow_code,
            'workflow_name' => $entry->workflow_name,
            'description' => $entry->description,
            'dept_ids' => $entry->dept_ids ? explode(',',$entry->dept_ids) : [],
            'approval_method' => $entry->approval_method,
            'workflow_type' => $entry->workflow_type,
            'approver_type' => $entry->approver_type,
            'workflow_type_name' => workflow::WORKFLOW_TYPES[$entry->workflow_type] ?? null,
            'approver_ids' => $approverIds,
            'users' => $users,
            'creator_name' => $entry->creator? $entry->creator->name : null,
            'department_names' => $entry->department_names,
            'user_approvers' => implode(", ", $userApprovers),
            'valid' => $entry->valid,
//            'is_edit' => $entry->created_by == auth()->user()->id || check_user_permission(SystemPermissionEnum::EDIT_DEPARTMENT),
        ];

        return $data;
    }
}
