<?php

namespace App\Transformers;

use App\Models\AcceptanceRecord;
use App\Enums\SystemPermissionEnum;

use League\Fractal\TransformerAbstract;
use function App\Helper\check_user_permission;

class AcceptanceRecordTransformer extends TransformerAbstract
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
    protected $isDelete = false;
    protected $relation = false;
    public function __construct($isDelete = false, $relation = false)
    {
        $this->isDelete = $isDelete;
        $this->relation = $relation;
    }
    public function transform(AcceptanceRecord $entry)
    {
        $data = [
            'id' => $entry->id,
            'code' => $entry->code,
            'title' => $entry->title,
            'project_id' => $entry->project_id,
            'sent_date' => $entry->sent_date,
            'acceptance_date' => $entry->acceptance_date,
            'sender' => $entry->sender,
            'receiver' => $entry->receiver,
            'warranty_period' => $entry->warranty_period,
            'note' => $entry->note,
            'status_id' => $entry->status_id,
            'isEdit' => $entry->created_by == auth()->user()->id || check_user_permission(SystemPermissionEnum::EDIT_ACCEPTANCE_RECORD)
        ];
        if($this->isDelete) {
            $data['isDelete'] = $entry->created_by == auth()->user()->id || check_user_permission(SystemPermissionEnum::DELETE_ACCEPTANCE_RECORD);
            // if($entry->project->count()) {
            //     $data['isDelete'] = false;
            // }
        }
        if($this->relation) {
            $data['status'] = fractal($entry->status, new SystemStatusTransformer());
            $data['project'] = fractal($entry->project, new ProjectManagementTransformer());
            $data['project_title'] = $entry->project->code . ' - ' . $entry->project->name;
            $data['files'] = $entry->files;
        }
        return $data;
    }
}
