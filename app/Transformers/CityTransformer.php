<?php

namespace App\Transformers;

use App\Models\City;
use League\Fractal\TransformerAbstract;

class CityTransformer extends TransformerAbstract
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
    public function transform(City $entry)
    {
        return [
            'id' => $entry->id,
            'country_code' => $entry->country_code,
            'name' => $entry->name,
            // 'lat' => $entry->lat,
            // 'lng' => $entry->lng,
            // 'zipcode' => $entry->zipcode,
            // 'code' => $entry->code,
            'country_id' => $entry->country_id,
        ];
    }
}
