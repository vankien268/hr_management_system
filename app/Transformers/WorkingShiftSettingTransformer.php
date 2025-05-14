<?php

namespace App\Transformers;

use App\Models\WorkingShiftSetting;
use League\Fractal\TransformerAbstract;

class WorkingShiftSettingTransformer extends TransformerAbstract
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
    public function transform(WorkingShiftSetting $entry)
    {

        return [
            'id' => $entry->id,
            'shift_type' => $entry->shift_type,
            'shift_title' => $entry->shift_title,
            'description' => $entry->description,
            'active' => $entry->active,
            'shift_weekdays' => $entry->shift_weekdays ? json_decode($entry->shift_weekdays) : [],
            'attributes' => $entry->attributes ? json_decode($entry->attributes) : [],
            'valid' => $entry->valid,
            'working_shift_users' => $entry->working_shift_users,
            'users' => $entry->users,
        ];
    }

}
