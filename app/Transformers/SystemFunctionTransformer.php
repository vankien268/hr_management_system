<?php

namespace App\Transformers;

use App\Models\SystemFunction;
use League\Fractal\TransformerAbstract;

class SystemFunctionTransformer extends TransformerAbstract
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
    public function transform(SystemFunction $entry)
    {
        return [
            'id' => $entry->id,
            'name' => $entry->name,
            'childrents' => $entry->children->pluck('id')->toArray(),
            'descendants' => $entry->descendants->pluck('id')->toArray(),
            'parent_id' => $entry->parent_id,
            'depth' => $entry->depth,
            'related_array_id' => $entry->related_array_id ? json_decode($entry->related_array_id) : [],
            'blocked_array_id' => $entry->blocked_array_id ? json_decode($entry->blocked_array_id) : [],
            'checked' => false
        ];
    }
}
