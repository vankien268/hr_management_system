<?php

namespace App\Transformers;

use App\Models\Customer;
use League\Fractal\TransformerAbstract;

class CustomerReportTransformer extends TransformerAbstract
{
    protected $option;
    public function __construct($option = [])
    {
        $this->option = $option;
    }
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
    public function transform(Customer $entry)
    {
        $data = [
            'id' => $entry->id,
            'code' => $entry->code,
            'name' => $entry->name,
            'tax_code' => $entry->tax_code,
            'address' => $entry->address,
            'city_id' => $entry->city_id,
            'district_id' => $entry->district_id,
            'ward_id' => $entry->ward_id,
            'full_address' => $entry->getFullAddress(),
            'representative_name' => $entry->representative_name,
            'representative_phone' => $entry->representative_phone,
            'representative_email' => $entry->representative_email,
            'status_id' => $entry->status_id,
            'bank_number' => $entry->bank_number,
            'bank_username' => $entry->bank_username,
            'bank_id' => $entry->bank_id,
            'note' => $entry->note,
            'customer_type' => $entry->customer_type,
            'created_at_view' => $entry->created_at ? $entry->created_at->format('d/m/Y') : '',
            'created_at' => $entry->created_at ? $entry->created_at->format('Y-m-d') : '',
        ];

        if($entry->relationLoaded('status')){
            $data = array_merge($data, [
                'status' => fractal($entry->status, new SystemStatusTransformer())->toArray(),
            ]);
        }
        return $data;
    }
}
