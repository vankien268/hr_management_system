<?php

namespace App\Transformers;

use App\Models\Project;
use App\Transformers\ContactTransformer;
use League\Fractal\TransformerAbstract;

class ProjectManagementReportTransformer extends TransformerAbstract
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
            'created_at' => $entry->created_at->format('d/m/Y'),
            'functions' => $entry->functions
        ];
        if($this->relation) {
            $data['customer'] = fractal($entry->customer, new CustomerTransformer());
            $data['customer_title'] = $entry->customer->code . ' - ' . $entry->customer->name;
            $data['systemStatus'] = fractal($entry->statusProject, new SystemStatusTransformer());
            $data['city'] = fractal($entry->city, new CityTransformer());
            $data['users'] = fractal($entry->users, new UserTransformer(true, false, true));
            $data['projectType'] = fractal($entry->projectType, new ProjectTypeTransformer());
            $data['contacts'] = fractal($entry->contacts, new ContactTransformer(true));
            $data['tasks'] = fractal($entry->tasks, new TaskTransformer(true));
        }
        return $data;
    }
}
