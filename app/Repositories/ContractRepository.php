<?php

namespace App\Repositories;

use App\Enums\ProjectPermissionEnum;
use App\Enums\SystemPermissionEnum;
use App\Models\Contract;
use App\Models\Module;
use App\Repositories\Interfaces\IAnnexContractRepository;
use App\Repositories\Interfaces\IContractModuleRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Repositories\Interfaces\IContractRepository;
use App\Repositories\Interfaces\IPaymentDetailRepository;


use function App\Helper\check_user_permission;

class ContractRepository extends BaseRepository implements Interfaces\IContractRepository
{
    protected $paymentDetailRepository;
    protected $annexContractRepository;
    protected $contractModuleRepository;

    public function __construct(
        Contract $model,
        IPaymentDetailRepository $paymentDetailRepository,
        IAnnexContractRepository $annexContractRepository,
        IContractModuleRepository $contractModuleRepository,
    ) {
        $this->paymentDetailRepository = $paymentDetailRepository;
        $this->annexContractRepository = $annexContractRepository;
        $this->contractModuleRepository = $contractModuleRepository;
        $this->model = $model;
    }

    public function getData()
    {
        $viewListContractPermission = check_user_permission(SystemPermissionEnum::VIEW_LIST_CONTRACT);
        $searchData = request()->all();

        $results = $this->model->with(['customer', 'userContractor', 'userCharge', 'contractType', 'status', 'project', 'annexContracts', 'contractModules', 'paymentDetails', 'userCreate']);

        if (isset($searchData['code'])) {
            $results->where('code', 'like', '%' . $searchData['code'] . '%');
        }
        if (isset($searchData['customer_id'])) {
            $results->where('customer_id', $searchData['customer_id']);
        }
        if (isset($searchData['project_id'])) {
            $results->where('project_id', $searchData['project_id']);
        }
        if (isset($searchData['contract_type_id'])) {
            $results->where('contract_type_id', $searchData['contract_type_id']);
        }
        if (isset($searchData['status_id'])) {
            $results->where('status_id', $searchData['status_id']);
        }
        if (isset($searchData['user_charge_id'])) {
            $results->where('user_charge_id', $searchData['user_charge_id']);
        }
        if (isset($searchData['number_payment'])) {
            $results->where('number_payment', $searchData['number_payment']);
        }
        if (isset($searchData['warranty_time'])) {
            $results->where('warranty_time', $searchData['warranty_time']);
        }

        if (isset($searchData['is_signing']) && $searchData['is_signing'] === 'true') {
            $results->where('signing_date', '>=', $searchData['signing_from'])->where('signing_date', '<=', $searchData['signing_to']);
        }

        if (isset($searchData['is_expiration']) && $searchData['is_expiration'] === 'true') {
            $results->where('expiration_date', '>=', $searchData['expiration_from'])->where('expiration_date', '<=', $searchData['expiration_to']);
        }
        // Nếu không phải quyền hệ thống
        if (!$viewListContractPermission) {
            $userHasPermissionProjectIds =  $this->model->userPermissions(true);
            $results->whereIn('project_id', $userHasPermissionProjectIds);
        }
        return $results->orderBy('project_id');
    }

    public function formatDataStore()
    {
        $requestData = request()->all();
        if (isset($requestData['contract_value']) && is_string($requestData['contract_value'])) {
            $requestData['contract_value'] = str_replace('.', '', $requestData['contract_value']);
        }

        // dd($requestData);
        return $requestData;
    }

    public function formatDataContractModules($datas): array
    {
        return array_map(function ($item) {
            if (isset($item['value']) && is_string($item['value'])) {
                $item['value'] = str_replace('.', '', $item['value']);
            }
            return $item;
        }, $datas);
    }

    public function formatDataPaymentDetails($datas): array
    {
        return array_map(function ($item, $key) {
            $item['payment_times'] = $key + 1;
            if (isset($item['amount']) && is_string($item['amount'])) {
                $item['amount'] = str_replace('.', '', $item['amount']);
            }
            if (isset($item['actual_amount']) && is_string($item['actual_amount'])) {
                $item['actual_amount'] = str_replace('.', '', $item['actual_amount']);
            }
            return $item;
        }, $datas, array_keys($datas));
    }
    public function formatDataUpdate()
    {
        $requestData = request()->all();
        // unset($requestData['code']);
        if (isset($requestData['contract_value']) && is_string($requestData['contract_value'])) {
            $requestData['contract_value'] = str_replace('.', '', $requestData['contract_value']);
        }
        // $requestData['updated_by'] = rand(1,strtotime("now"));
        return $requestData;
    }

    public function updateContract($contract)
    {
        $dataUpdate = request()->all();
        $contract = $contract->load(['contractModules', 'annexContracts', 'paymentDetails']);

        $contractModuleIds = $contract->contractModules->pluck('id')->toArray();
        foreach ($this->formatDataContractModules($dataUpdate['contract_modules']['data']) as $key => $item) {
            $module = Module::firstOrCreate(['name' => $item['module']]);
            $item = array_merge($item, ['module_id' => $module->id]);
            if ($item['id'] != 0) {
                /**
                 * Cập nhật hạng mục thực hiện của hợp đồng
                 */
                $this->contractModuleRepository->update($item['id'], $item);
            } else {

                /** @var mixed
                 * TODO: thêm mới hạng mục thực hiện của hợp đồng
                 */
                $item = array_merge($item, ['contract_id' => $contract->id]);
                $this->contractModuleRepository->create($item);
            }

            $index = array_search($item['id'], $contractModuleIds);
            if ($index !== false) {
                unset($contractModuleIds[$index]);
            }
        }
        /**
         * TODO: Xóa hạng mục thực hiện
         */
        if (count($contractModuleIds) > 0) {
            $this->contractModuleRepository->destroy($contractModuleIds);
        }

        /** @var mixed
         * TODO: Phụ lục hợp đồng - thêm - sửa - xóa
         */
        $annexContractIds = $contract->annexContracts->pluck('id')->toArray();
        foreach ($dataUpdate['annex_contracts']['data'] as $key => $item) {
            if ($item['id'] != 0) {
                $this->annexContractRepository->update($item['id'], $item);
            } else {
                $item = array_merge($item, ['contract_id' => $contract->id]);
                $this->annexContractRepository->create($item);
            }

            $index = array_search($item['id'], $annexContractIds);
            if ($index !== false) {
                unset($annexContractIds[$index]);
            }
        }
        /**
         * TODO: Xóa Phụ lục hợp đồng
         */
        if (count($annexContractIds) > 0) {
            $this->annexContractRepository->destroy($annexContractIds);
        }


        /** @var mixed
         * TODO: Số lần thanh toán- thêm - sửa - xóa
         */
        $paymentDetailIds = $contract->paymentDetails->pluck('id')->toArray();
        foreach ($this->formatDataPaymentDetails($dataUpdate['payment_details']['data']) as $key => $item) {
            // $item['payment_times'] = $key + 1;
            if ($item['id'] != 0) {
                $this->paymentDetailRepository->update($item['id'], $item);
            } else {
                $item = array_merge($item, ['contract_id' => $contract->id]);
                $this->paymentDetailRepository->create($item);
            }

            $index = array_search($item['id'], $paymentDetailIds);
            if ($index !== false) {
                unset($paymentDetailIds[$index]);
            }
        }

        /**
         * TODO: Xóa Số lần thanh toán
         */

        if (count($paymentDetailIds) > 0) {
            $this->paymentDetailRepository->destroy($paymentDetailIds);
        }
    }
}
