<?php

namespace App\Transformers;

use App\Enums\ProjectPermissionEnum;
use App\Enums\SystemPermissionEnum;
use App\Models\Contract;
use League\Fractal\TransformerAbstract;
use function App\Helper\check_user_permission;

class ContractTransformer extends TransformerAbstract
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

    public function transform(Contract $entry)
    {
        $data = [
            'id' => $entry->id,
            'code' => $entry->code,
            'signing_date' => $entry->signing_date,
            'project_id' => $entry->project_id,
            'project_name' => $entry->project->name ?? '',
            'customer_id' => $entry->customer_id,
            'user_contractor_id' => $entry->user_contractor_id,
            'user_charge_id' => $entry->user_charge_id,
            'customer_contractor' => $entry->customer_contractor,
            'contract_type_id' => $entry->contract_type_id,
            'contract_value' => $entry->contract_value,
            'start_date' => $entry->start_date,
            'expiration_date' => $entry->expiration_date,
            'hand_over_date' => $entry->hand_over_date,
            'number_payment' => $entry->number_payment,
            'warranty_time' => $entry->warranty_time,
            'status_id' => $entry->status_id,
            'note_contract' => $entry->note_contract,
            'canPermissionEditContract' => $entry->created_by == auth()->user()->id || $entry->checkEditOrDeletePermissionContract(
                ProjectPermissionEnum::EDIT_CONTRACT, $entry->project_id
            ) || check_user_permission(SystemPermissionEnum::SYSTEM_EDIT_CONTRACT),
            'canPermissionDeleteContract' => $entry->created_by == auth()->user()->id || $entry->checkEditOrDeletePermissionContract(
                ProjectPermissionEnum::DELETE_CONTRACT, $entry->project_id
            ) || check_user_permission(SystemPermissionEnum::SYSTEM_DELETE_CONTRACT),

            'canPermisisonViewPaymentContract' => $entry->checkNumerPaymentContract(
               ProjectPermissionEnum::VIEW_DETAIL_PAYMENT_CONTRACT,
                $entry->project_id
            ) || check_user_permission(SystemPermissionEnum::SYSTEM_EDIT_CONTRACT),

            'userCreateContract' => $entry->checkUserCreate(@$entry->userCreate->id),
            'paymentDetails' => fractal($entry->paymentDetails, new PaymentDetailTransformer())->toArray(),
            'permission_contract_value' => $entry->checkPermissionContract(ProjectPermissionEnum::VIEW_PRICE_CONTRACT, $entry->project_id)
            || check_user_permission(SystemPermissionEnum::SYSTEM_EDIT_CONTRACT)
        ];

        if($entry->relationLoaded('status')){
            $data = array_merge($data, [
                'status' => fractal($entry->status, new SystemStatusTransformer())->toArray(),
            ]);
        }

        if($entry->relationLoaded('project')){
            $data = array_merge($data, [
                'project' => fractal($entry->project, new ProjectManagementTransformer())->toArray(),
            ]);
        }
        if($entry->relationLoaded('customer')){
            $data = array_merge($data, [
                'customer' => fractal($entry->customer, new CustomerTransformer())->toArray(),
            ]);
        }

        if($entry->relationLoaded('contractType')){
            $data = array_merge($data, [
                'contract_type' => fractal($entry->contractType, new ContractTypeTransformer())->toArray(),
            ]);
        }

        if($entry->relationLoaded('userContractor')){
            $data = array_merge($data, [
                'user_contractor' => fractal($entry->userContractor, new UserTransformer())->toArray(),
            ]);
        }

        if($entry->relationLoaded('userCharge')){
            $data = array_merge($data, [
                'user_charge' => fractal($entry->userCharge, new UserTransformer())->toArray(),
            ]);
        }

        if($entry->relationLoaded('annexContracts')){
            $data = array_merge($data, [
                'annex_contracts' => fractal($entry->annexContracts, new AnnexContractTransformer())->toArray(),
            ]);
        }

        if($entry->relationLoaded('contractModules')){
            $data = array_merge($data, [
                'contract_modules' => fractal($entry->contractModules, new ContractModuleTransformer())->toArray(),
            ]);
        }

        if($entry->relationLoaded('paymentDetails')){
            $data = array_merge($data, [
                'payment_details' => fractal($entry->paymentDetails, new PaymentDetailTransformer())->toArray(),
            ]);
        }

        if(array_key_exists('is_delete', $this->option) && $this->option['is_delete'] === true){
            $delete = true;
            if($entry->paymentDetails->count() > 0 || $entry->contractModules->count() > 0 || $entry->annexContracts->count() > 0){
                $delete = false;
            }
            $data = array_merge($data, [
                'is_delete' => $delete
            ]);
        }

        return $data;
    }
}
