<?php

namespace App\Transformers;

use App\Models\Ward;
use League\Fractal\TransformerAbstract;
use App\Transformers\DistrictTransformer;

class WardTransformer extends TransformerAbstract
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
        'district',
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Ward $entry)
    {
        return [
            'id' => $entry->id,
            'name' => $entry->name,
            'prefix' => $entry->prefix,
            'district_id' => $entry->district_id,
        ];
    }

    public function includeDistrict(Ward $entry)
    {
        $district = $entry->district;
        if($district){
            return $this->item($district, new DistrictTransformer());
        }
        return null;
    }
}
