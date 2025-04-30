<?php

namespace App\Transformers;

use App\Models\District;
use App\Transformers\CityTransformer;
use League\Fractal\TransformerAbstract;

class DistrictTransformer extends TransformerAbstract
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
        'city', 'wards',
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(District $entry)
    {
        return [
            'id' => $entry->id,
            'name' => $entry->name,
            'city_id' => $entry->city_id,
        ];
    }

    public function includeCity(District $entry)
    {
        $city = $entry->city;
        if($city){
            return $this->item($city, new CityTransformer());
        }
        return null;
    }

    public function includeWards(District $entry)
    {
        $wards = $entry->wards;
        if($wards){
            return $this->collection($wards, new WardTransformer());
        }
        return null;
    }
}
