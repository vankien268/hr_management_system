<?php

namespace App\Transformers;

use App\Models\Module;
use League\Fractal\TransformerAbstract;

class ModuleTransformer extends TransformerAbstract
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
    public function transform(Module $entry)
    {
        return [
            'id' => $entry->id,
            'name' => $entry->name,
        ];
    }
}
