<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HrmContactUpdateRequest;
use App\Http\Requests\HrmContractStoreRequest;
use App\Http\Requests\HrmContractUpdateRequest;
use App\Repositories\Interfaces\IHrmContactRepository;
use App\Repositories\Interfaces\IHrmContractRepository;
use App\Transformers\HrmContactTransformer;
use App\Transformers\HrmContractTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HrmContractController extends Controller
{

    /**
     * @var IHrmContractRepository
     */
    private $contractRepository;

    public function __construct(IHrmContractRepository $contractRepository)
    {
        $this->contractRepository = $contractRepository;
    }


    public function index()
    {
        $breadcrums = [
            'text' => trans('Quản lý hợp đồng nhân sự')
        ];
//        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_PRODUCT);
        $data = [
            'breadcrums' => $breadcrums,
            'pageName' => trans('Quản lý hợp đồng nhân sự'),
            'btnAdd' => true,
        ];
        return view('admin.hrm-contracts.index')->with($data);
    }

    public function getAllHrmContracts(Request $request)
    {
        $fullName = $request->full_name;
        $contract_type_id = $request->contract_type_id;
        $contract_name = $request->contract_name;
        $contract_code = $request->contract_code;

        $stt = 1;
        $contacts = $this->contractRepository->model(['department', 'contact', 'contractType'])
            ->where(function ($query) use (
                $contract_code,
                $contract_name,
                $contract_type_id,
                $fullName
            ) {

                if ($contract_code) {
                    $query->where('contract_code', 'like', '%' . $contract_code . '%');
                }

                if ($contract_name) {
                    $query->where('contract_name', 'like', '%' . $contract_name . '%');
                }

                if ($contract_type_id) {
                    $query->where('contract_type_id', $contract_type_id);
                }

                if ($fullName) {
                    $query->whereHas('contact', function ($q) use ($fullName) {
                        $q->where('full_name', 'like', '%' . $fullName . '%');
                    });
                }
            })->where('valid', 1)
            ->orderByDesc('id')->get()->map(function ($item) use(&$stt) {
                $item->stt = $stt;
                $stt++;
                return $item;
            });

        $this->setTransformer(new HrmContractTransformer());

        return $this->responseCollection(
            $contacts,
            200
        );
    }

    public function store(HrmContractStoreRequest $request)
    {
        $data = $request->all();
        $data['allowances'] = isset($data['allowances']) && is_array($data['allowances']) ? implode(',', $data['allowances']) : null;

        DB::beginTransaction();
        try {
            $this->contractRepository->create($data);
            DB::commit();
            return $this->successResponse(['message' => trans('Thêm hợp đồng thành công!')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function update($id, HrmContractUpdateRequest $request)
    {

        $contract = $this->contractRepository->find($id);

        if (! $contract) {
            return $this->errorsResponse(['message' => trans('Hợp đồng không tồn tại.')], 422);
        }

        $data = $request->all();

        $data['allowances'] = isset($data['allowances']) && is_array($data['allowances']) ? implode(',', $data['allowances']) : null;

        unset($data['id']);
        DB::beginTransaction();
        try {

            $contract->update($data);
            DB::commit();
            return $this->successResponse(['contract' => $contract->refresh(), 'message' => trans('Sửa hợp đồng thành công!')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy($id)
    {
        $contract = $this->contractRepository->find($id);

        if (! $contract) {
            return $this->errorsResponse(['message' => trans('Hợp đồng không tồn tại.')], 422);
        }

        DB::beginTransaction();
        try {
            $contract->update(['valid' => 0]);
            DB::commit();
            return $this->successResponse(['message' => trans('Xóa hợp đồng thành công !')]);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return $this->errorResponse($throwable->getMessage());
        }
    }
}
