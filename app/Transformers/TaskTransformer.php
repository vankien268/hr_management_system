<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Task;
use Carbon\Carbon;

class TaskTransformer extends TransformerAbstract
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
    protected $currenUser = false;

    public function __construct($currenUser=false)
    {
        $this->currenUser = $currenUser;
    }
    public function transform(Task $entry)
    {
        $data = [
            'id' => $entry->id,
            'date' => $entry->date ,
            'user_id' => $entry->user_id,
            'user_name' => isset($entry->user->name) ? $entry->user->name : null,
            'project_id' => $entry->project_id,
            'status_id' => $entry->status_id,
            'description' => $entry->description,
            'note' => $entry->note
        ];
        if($this->currenUser) {
            $data['userCurrent'] = @auth()->user()->name ?? 'Không có tên';
        }

        return $data;
    }
}
