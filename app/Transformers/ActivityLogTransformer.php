<?php

namespace App\Transformers;

use App\Enums\SystemPermissionEnum;
use App\Models\ActivityLog;
use App\Models\ContractModule;
use App\Models\PaymentDetail;
use League\Fractal\TransformerAbstract;

use function App\Helper\check_user_permission;

class ActivityLogTransformer extends TransformerAbstract
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
    protected $relation = false;
    protected $relationHistory = [];
    public function __construct($relation = false, $relationHistory = [])
    {
        $this->relation = $relation;
        $this->relationHistory = $relationHistory;
    }
    public function transform(ActivityLog $entry)
    {
        // $getKeyPropertyOld = json_decode($entry->properties, true);
        $data = [
            'id' => $entry->id,
            'log_name' => $entry->log_name,
            'description' => $entry->description,
            'subject_type' => $entry->subject_type,
            'event' => $entry->event,
            'subject_id' => $entry->subject_id,
            'causer_type' => $entry->causer_type,
            'causer_id ' => $entry->causer_id ,
            'properties' => $entry->properties,
            'batch_uuid' => $entry->batch_uuid,
            'isEdit' => $entry->created_by == auth()->user()->id || check_user_permission(SystemPermissionEnum::EDIT_BANK),
            'created_at' => $entry->created_at,
            'jsonNewCity' => $entry->jsonNewCity,
            'jsonOldCity' => $entry->jsonOldCity,
            'jsonNewDistrict' => $entry->jsonNewDistrict,
            'jsonOldDistrict' => $entry->jsonOldDistrict,
            'jsonNewWard' => $entry->jsonNewWard,
            'jsonOldWard' => $entry->jsonOldWard,
            'jsonNewBank' => $entry->jsonNewBank,
            'jsonOldBank' => $entry->jsonOldBank,
            'jsonNewProject' => $entry->jsonNewProject,
            'jsonOldProject' => $entry->jsonOldProject,
            'jsonNewUserContractor' => $entry->jsonNewUserContractor,
            'jsonOldUserContractor' => $entry->jsonOldUserContractor,
            'jsonNewUserCharge' => $entry->jsonNewUserCharge,
            'jsonOldUserCharge' => $entry->jsonOldUserCharge,
            'jsonNewContractType' => $entry->jsonNewContractType,
            'jsonOldContractType' => $entry->jsonOldContractType,
            'jsonNewContract' => $entry->jsonNewContract,
            'jsonOldContract' => $entry->jsonOldContract,
            'jsonNewModule' => $entry->jsonNewModule,
            'jsonOldModule' => $entry->jsonOldModule,
            'jsonNewUserChargeCustomer' => $entry->jsonNewUserChargeCustomer,
            'jsonOldUserChargeCustomer' => $entry->jsonOldUserChargeCustomer,
        ];
        if($this->relation) {
            $data['user'] = fractal($entry->user, new UserTransformer());
            $data['customer'] = fractal($entry->customer, new CustomerTransformer());
            $data['contract'] = fractal($entry->contract, new ContractTransformer());
            $data['paymentDetail'] = fractal($entry->paymentDetail, new PaymentDetailTransformer(true));
            $data['annexContract'] = fractal($entry->annexContract, new AnnexContractTransformer(true));
            $data['contractModule'] = fractal($entry->contractModule, new ContractModuleTransformer(true));
            // $data['userCharge'] = $entry->user->name . ' ( ' . $entry->user->username . ' ) ' ;
        }

        if(in_array('project', $this->relationHistory)) {
            $data['jsonNewSystemStatus'] =  $entry->jsonNewSystemStatus;
            $data['jsonOldSystemStatus'] =  $entry->jsonOldSystemStatus;

            $data['jsonNewCustomer'] =  $entry->jsonNewCustomer;
            $data['jsonOldCustomer'] =  $entry->jsonOldCustomer;

            $data['jsonNewUser'] =  $entry->jsonNewUserWithHistoryProject;
            $data['jsonOldUser'] =  $entry->jsonOldUserWithHistoryProject;

            $data['jsonNewProjectType'] =  $entry->jsonNewProjectType;
            $data['jsonOldProjectType'] =  $entry->jsonOldProjectType;
        }

        return $data;
    }

    // public function convertColumnProjectToNameField($data)
    // {
    //     $dataNew= [];
    //     if(isset($data['name'])) {
    //         $dataNew[] = 'Tên dự án';
    //     }
    //     if(isset($data['city_id'])) {
    //         $dataNew[] = 'Khu vực ';
    //     }
    //     if(isset($data['status_id'])) {
    //         $dataNew[] = 'Trạng thái';
    //     }
    //     if(isset($data['project_type_id'])) {
    //         $dataNew[] = 'Phân loại dự án';
    //     }
    //     if(isset($data['customer_id'])) {
    //         $dataNew[] = 'Khách hàng';
    //     }
    //     if(isset($data['description'])) {
    //         $dataNew[] = 'Mô tả sơ bộ';
    //     }
    //     return $dataNew;
    // }
}
