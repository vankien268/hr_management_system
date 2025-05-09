<?php

namespace App\Transformers;

use App\Models\RequestTicket;
use Illuminate\Support\Facades\DB;
use League\Fractal\TransformerAbstract;

class RequestTicketTransformer extends TransformerAbstract
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
    public function transform(RequestTicket $entry)
    {

        if(! $this->users) {
            $this->users = DB::table('users')->get()->keyBy('id');
        }

        $approverIds = $entry->approver_ids ? explode(',',$entry->approver_ids) : [];

        $userApprovers = [];

        # user duyệt
        if($entry->approver_type == "user") {
            foreach ($approverIds as $approverId) {
                $user = $this->users[$approverId] ?? null;

                if($user == null) {
                    continue;
                }

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
            'request_title' => $entry->request_title,
            'request_description' => $entry->request_description,
            'start_date' => $entry->start_date,
            'end_date' => $entry->end_date,
            'number_leave_day' => $entry->number_leave_day,
            'approval_type' => $entry->approval_type,
            'workflow_id' => $entry->workflow_id,
            'workflow_name' => $entry->workflow ? $entry->workflow->workflow_name : null,
            'request_status' => $entry->request_status,
            'valid' => $entry->valid,
            'creator_name' => $entry->creator? $entry->creator->name : null,
            'request_status_name' => RequestTicket::REQUEST_STATUSES[$entry->request_status] ?? null,
            'approve_name' => null,
            'user_approvers' => implode(", ", ($userApprovers)),
            'created_at' => $entry->created_at->format('d/m/Y'),
//            'is_edit' => $entry->created_by == auth()->user()->id || check_user_permission(SystemPermissionEnum::EDIT_DEPARTMENT),
        ];
        return $data;
    }
}
