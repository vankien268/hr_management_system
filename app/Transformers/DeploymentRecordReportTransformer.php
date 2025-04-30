<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\DeploymentRecord;

class DeploymentRecordReportTransformer extends TransformerAbstract
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
    public function transform(DeploymentRecord $entry)
    {
        $data = [
            'id' => $entry->id,
            'code' => $entry->code,
            'title' => $entry->title,
            'project_id' => $entry->project_id,
            'handover_date' => $entry->handover_date,
            'handover_person' => $entry->handover_person,
            'receiver' => $entry->receiver,
            'note' => $entry->note,
            'status_id' => $entry->status_id,
        ];
        if($this->relation) {
            $data['status'] = fractal($entry->status, new SystemStatusTransformer());
            $data['project'] = fractal($entry->project, new ProjectManagementTransformer());
            $data['project_title'] = $entry->project->code . ' - ' . $entry->project->name;
        }
        return $data;
    }
}
