<?php

namespace App\Transformers;

use App\Models\PayRoll;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class PayRollTransformer extends TransformerAbstract
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
    public function transform(PayRoll $entry)
    {
        $endDate = $entry->end_date ? Carbon::parse($entry->end_date) : null;

        return [
            'id' => $entry->id,
            'pay_roll_name' => $entry->pay_roll_name,
            'start_date' => $entry->start_date ? Carbon::parse($entry->start_date)->format('Y-m-d') : null,
            'end_date' => $entry->end_date ? Carbon::parse($entry->end_date)->format('Y-m-d') : null,
            'description' => $entry->description,
            'pay_ranges' => $entry->pay_ranges,
            'status' => $endDate && $endDate->lte(Carbon::now()),
        ];
    }
}
