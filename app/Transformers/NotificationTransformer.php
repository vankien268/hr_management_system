<?php

namespace App\Transformers;

use App\Models\Notification;
use League\Fractal\TransformerAbstract;

class NotificationTransformer extends TransformerAbstract
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
    public function transform(Notification $entry)
    {
        // dd(json_decode($entry->data)->project);
        $data = [
            'id' => $entry->id,
            'type' => $entry->type,
            'notifiable_type' => $entry->notifiable_type,
            'notifiable_id' => $entry->notifiable_id,
            'data' => json_decode($entry->data),
             'read_at' => $entry->read_at,
            'created_at' => $entry->created_at
        ];
        return $data;
    }
}
