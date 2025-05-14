<?php

namespace App\Transformers;

use App\Models\Timekeeping;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class TimeKeepingTransformer extends TransformerAbstract
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
    public function transform(Timekeeping $entry)
    {
        return [
            'id' => $entry->id,
            'user_id' => $entry->user_id,
            'shift_id' => $entry->shift_id,
            'check_in' => $entry->check_in  ,
            'check_in_time' =>  Carbon::parse($entry->check_in)->format('H:i'),
            'check_out' =>  $entry->check_out ,
            'check_out_time' =>  $entry->check_out ?  Carbon::parse($entry->check_out)->format('H:i'): null,
            'checkin_date' => Carbon::parse($entry->checkin_date)->format('Y-m-d'),
            'description' => $entry->description,
            'attributes' => $entry->attributes,
            'logs' => $entry->logs,
            'valid' => $entry->valid,
        ];
    }
}
