<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AllowanceStoreRequest;
use App\Http\Requests\AllowanceUpdateRequest;
use App\Http\Requests\InternalFundUpdateRequest;
use App\Models\InitValue;
use App\Repositories\Interfaces\IAllowanceRepository;
use App\Repositories\Interfaces\IInitValueRepository;
use App\Transformers\AllowanceTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InternalFundController extends Controller
{
    private $initValueRepository;

    public function __construct(IInitValueRepository $initValueRepository)
    {
        $this->initValueRepository = $initValueRepository;
    }

    public function index()
    {
        $breadcrums = [
            'text' => trans('Quỹ nội bộ')
        ];
//        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_PRODUCT);
        $data = [
            'breadcrums' => $breadcrums,
            'pageName' => trans('Quỹ nội bộ'),
            'btnAdd' => true,
        ];
        return view('admin.internal-fund.index')->with($data);
    }

    public function getInfoInternalFund(Request $request)
    {
        $internalFundType = $this->initValueRepository->model()
            ->where('init_name', InitValue::INIT_NAME_INTERNAL_FUND_TYPE)
            ->first();

        $internalFund = $this->initValueRepository->model()
            ->where('init_name', InitValue::INIT_NAME_INTERNAL_FUND)
            ->first();

        $data = [
            'internal_fund' => $internalFund ? $internalFund->init_value : 0,
            'internal_fund_type' => $internalFundType ? $internalFundType->init_value : 'percent'
        ];

        return response()->json($data);
    }

    public function update(InternalFundUpdateRequest $request)
    {
        $data = $request->all();
        DB::beginTransaction();
        try {

            # Type
            $internalFundType = $this->initValueRepository->model()
                ->where('init_name', InitValue::INIT_NAME_INTERNAL_FUND_TYPE)
                ->first();

            if(! $internalFundType) {
                $this->initValueRepository->create([
                    'init_name' =>  InitValue::INIT_NAME_INTERNAL_FUND_TYPE,
                    'init_value' => $data['internal_fund_type'] ?? "percent"
                ]);
            }else {
                $internalFundType->update([
                    'init_value' => $data['internal_fund_type'] ?? "percent"
                ]);
            }

            # Value
            $internalFund = $this->initValueRepository->model()
                ->where('init_name', InitValue::INIT_NAME_INTERNAL_FUND)
                ->first();

            if(! $internalFund) {
                $this->initValueRepository->create([
                    'init_name' =>  InitValue::INIT_NAME_INTERNAL_FUND,
                    'init_value' => $data['internal_fund'] ?? 0
                ]);

            }else{
                $internalFund->update([
                    'init_value' => $data['internal_fund'] ?? 0
                ]);
            }

            DB::commit();
            return $this->successResponse(['message' => trans('Cập nhật quỹ nội bộ thành công!')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }
}
