<?php

namespace App\Transformers;

use App\Models\SalaryContact;
use League\Fractal\TransformerAbstract;

class SalaryContactTransformer extends TransformerAbstract
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
    public function transform(SalaryContact $entry)
    {
        return [
            'id' => $entry->id,
            'salary_id' => $entry->salary_id,
            'contact_id' => $entry->contact_id,
            'department_id' => $entry->department_id,
            'salary_month' => $entry->salary_month,
            'salary_year' => $entry->salary_year,
            'attributes' => $entry->attributes ? json_decode($entry->attributes) : [],
            'contact_code' => $entry->contact_code,
            'full_name' => $entry->full_name,
            'department_name' => $entry->department_name,
        ];
    }
}
