<?php

namespace App\Transformers;

use App\Models\DeploymentScheduleDetail;
use League\Fractal\TransformerAbstract;

class DeploymentScheduleDetailTransformer extends TransformerAbstract
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
    public function transform(DeploymentScheduleDetail $entry)
    {
        $data = [
            'id' => $entry->id,
            'deployment_schedule_id' => $entry->deployment_schedule_id,
            'day' => $entry->day,
            'shift' => $entry->shift,
            'product_function' => $entry->product_function,
            'description' => $entry->description
        ];
        return $data;
    }
}
