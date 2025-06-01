<?php

namespace App\Transformers;

use App\Models\Salaries;
use Illuminate\Support\Facades\DB;
use League\Fractal\TransformerAbstract;

class SalaryTransformer extends TransformerAbstract
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
    public function transform(Salaries $entry)
    {
        $departmentIds = $entry->department_ids ? explode(',', $entry->department_ids): [];
        $departments = DB::table('departments')->whereIn('id', $departmentIds)->get()->toArray();
        $data = [
            'id' => $entry->id,
            'name' => $entry->name,
            'month' => $entry->month,
            'year' => $entry->year,
            'department_ids' =>  $departments,
            'department_names' =>  $entry->department_names,
//            'is_edit' => check_user_permission(SystemPermissionEnum::EDIT_TAXES),
//            'is_delete' => check_user_permission(SystemPermissionEnum::DELETE_TAXES),
        ];
        return $data;
    }
}
