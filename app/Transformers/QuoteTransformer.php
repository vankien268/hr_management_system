<?php

namespace App\Transformers;

use App\Enums\ProjectPermissionEnum;
use App\Enums\QuoteStatusEnum;
use App\Enums\SystemPermissionEnum;
use App\Models\Quote;
use League\Fractal\TransformerAbstract;

use function App\Helper\check_user_is_admin;
use function App\Helper\check_user_permission;

class QuoteTransformer extends TransformerAbstract
{
    protected $option;
    public function __construct($option = [])
    {
        $this->option = $option;
    }
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
    public function transform(Quote $entry)
    {
        $checkUserCreate = $entry->checkUserCreate($entry->created_by);
        $data = [
            'id' => $entry->id,
            'code' => $entry->code,
            'title' => $entry->title,
            'contract_type_id' => $entry->contract_type_id,
            'project_id' => $entry->project_id,
            'customer_id' => $entry->customer_id,
            'approve_id' => $entry->approve_id,
            'total_amount' => $entry->total_amount,
            'quote_date' => $entry->quote_date,
            'receiver' => $entry->receiver,
            'email' => $entry->email,
            'phone' => $entry->phone,
            'note' => $entry->note,
            'status' => $entry->status,
            'list_status' => $entry->getListStatus($entry->status),
            'text_status' => $entry->getTextStatus(),
            'editable' => $entry->status === QuoteStatusEnum::NOT_APPROVED_YET && (check_user_permission(SystemPermissionEnum::EDIT_PRICE_QUOTES, $entry->project_id) || check_user_permission(SystemPermissionEnum::EDIT_SYSTEM_PRICE_QUOTE)),
            'created_by' => $entry->creator,
            'is_delete' => $entry->status === QuoteStatusEnum::NOT_APPROVED_YET && (check_user_permission(SystemPermissionEnum::DELETE_PRICE_QUOTES, $entry->project_id) || check_user_permission(SystemPermissionEnum::DELETE_SYSTEM_PRICE_QUOTE)),
            'canUserCreateQuote' => $entry->checkUserCreate(@$entry->created_by),
            'canUserPermissionEditQuote' => $entry->created_by == auth()->user()->id || $entry->checkEditOrDeletePermissionContract(
                ProjectPermissionEnum::EDIT_PRICE_QUOTES, $entry->project_id
            ) || check_user_permission(SystemPermissionEnum::EDIT_SYSTEM_PRICE_QUOTE),

            'canUserPermissionDeleteQuote' => $entry->created_by == auth()->user()->id || $entry->checkEditOrDeletePermissionContract(
                ProjectPermissionEnum::DELETE_PRICE_QUOTES, $entry->project_id
            ) || check_user_permission(SystemPermissionEnum::DELETE_SYSTEM_PRICE_QUOTE),
            'canApproveQuote' => false,
        ];
        // dd($this->option);
        if(array_key_exists('approve_permission', $this->option))
        {
            // dd(3);
            $data = array_merge($data, [
                'canApproveQuote' => check_user_is_admin() || ($this->option['approve_permission'] && $entry->approve_id == auth()->user()->id),
            ]);
        }

        if($entry->relationLoaded('contractType')){
            $data = array_merge($data, [
                'contract_type' => fractal($entry->contractType, new ContractTypeTransformer()),
            ]);
        }
        if($entry->relationLoaded('project')){
            $data = array_merge($data, [
                'project' => fractal($entry->project, new ProjectManagementTransformer()),
                'project_title' => $entry->project ? "<p class='pb-2'>".trans('Dự án: ') . $entry->project->code. ' - ' . $entry->project->name . "</p><p>" . trans('Khách hàng: ') . $entry->customer->code. ' - ' . $entry->customer->name . '</p>' : '',
            ]);
        }
        if($entry->relationLoaded('customer')){
            $data = array_merge($data, [
                'customer' => fractal($entry->customer, new CustomerTransformer()),
            ]);
        }
        if($entry->relationLoaded('approveBy')){
            $data = array_merge($data, [
                'approve_by' => fractal($entry->approveBy, new UserTransformer()),
            ]);
        }
        if($entry->relationLoaded('details')){
            $data = array_merge($data, [
                'details' => fractal($entry->details, new QuoteProductTransformer()),
            ]);
        }

        return $data;
    }
}
