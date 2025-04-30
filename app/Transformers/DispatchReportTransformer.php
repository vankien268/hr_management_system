<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Dispatch;

class DispatchReportTransformer extends TransformerAbstract
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
    public function transform(Dispatch $entry)
    {
        $data = [
            'id' => $entry->id,
            'code' => $entry->code,
            'number' => $entry->number,
            'name' => $entry->name,
            'type' => $entry->type,
            'date' => $entry->date,
            'project_id' => $entry->project_id,
            'customer_id' => $entry->customer_id,
            'content' => $entry->content,
            'sender' => $entry->sender,
            'receiver' => $entry->receiver,
            'from_date' => $entry->from_date,
            'to_date' => $entry->to_date,
            'note' => $entry->note,
            'status_id' => $entry->status_id,
        ];
        if($this->relation) {
            $data['status'] = fractal($entry->status, new SystemStatusTransformer());
            $data['project'] = fractal($entry->project, new ProjectManagementTransformer());
            $data['customer'] = fractal($entry->customer, new CustomerTransformer());
            $data['project_customer_title'] = '<p class="pt-1 pb-1">'.$entry->project->code . ' - ' . $entry->project->name .'</p>'. '<p class="pb-1">'. $entry->customer->code. ' - ' . $entry->customer->name. '<p>';
        }
        return $data;
    }
}
