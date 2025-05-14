<?php

namespace App\Transformers;

use App\Models\SalaryGrade;
use League\Fractal\TransformerAbstract;

class SalaryGradeTransformer extends TransformerAbstract
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
    public function transform(SalaryGrade $entry)
    {
        return [
            'id' => $entry->id,
            'name' => $entry->name,
            'coefficient_one' => $entry->coefficient_one,
            'value_one' => $entry->value_one,
            'coefficient_two' => $entry->coefficient_two,
            'value_two' => $entry->value_two,
            'coefficient_three' => $entry->coefficient_three,
            'value_three' => $entry->value_three,
            'coefficient_four' => $entry->coefficient_four,
            'value_four' => $entry->value_four,
            'coefficient_five' => $entry->coefficient_five,
            'value_five' => $entry->value_five,
            'coefficient_six' => $entry->coefficient_six,
            'value_six' => $entry->value_six,
            'coefficient_seven' => $entry->coefficient_seven,
            'value_seven' => $entry->value_seven,
            'coefficient_eight' => $entry->coefficient_eight,
            'value_eight' => $entry->value_eight,
            'valid' => $entry->valid,
            'attributes' => $entry->attributes ? json_decode( $entry->attributes) : [],
        ];
    }
}
