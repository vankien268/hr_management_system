<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\AcceptanceRecord;

class AcceptanceRecordReportTransformer extends TransformerAbstract
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
        ];
        if($this->relation) {
            $data['status'] = fractal($entry->status, new SystemStatusTransformer());
            $data['project'] = fractal($entry->project, new ProjectManagementTransformer());
            $data['project_title'] = $entry->project->code . ' - ' . $entry->project->name;
        }
        return $data;
    }
}
