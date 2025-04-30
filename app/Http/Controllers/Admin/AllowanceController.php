<?php


namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Http\Requests\AllowanceStoreRequest;
use App\Http\Requests\AllowanceUpdateRequest;
use App\Repositories\Interfaces\IAllowanceRepository;
use App\Transformers\AllowanceTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AllowanceController extends Controller
{
    private $allowanceRepository;

    public function __construct(IAllowanceRepository $allowanceRepository)
    {
        $this->allowanceRepository = $allowanceRepository;
    }

    public function index()
    {
        $breadcrums = [
            'text' => trans('Khai báo phụ cấp')
        ];
//        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_PRODUCT);
        $data = [
            'breadcrums' => $breadcrums,
            'pageName' => trans('Khai báo phụ cấp'),
            'btnAdd' => true,
        ];
        return view('admin.allowances.index')->with($data);
    }

    public function getAllAllowances(Request $request)
    {
        $allowanceName = $request->allowance_name;
        $allowanceType = $request->allowance_type;

        $allowances = $this->allowanceRepository->model()
            ->where(function ($query) use ($allowanceName, $allowanceType) {
                if ($allowanceName) {
                    $query->where('allowance_name', 'like', '%' . $allowanceName . '%');
                }
                if ($allowanceType) {
                    $query->Where('allowance_type', $allowanceType);
                }
            })
            ->orderByDesc('id')->get();

        $this->setTransformer(new AllowanceTransformer());

        return $this->responseCollection(
            $allowances,
            200
        );
    }

    public function store(AllowanceStoreRequest $request)
    {
        $data = $request->all();
        DB::beginTransaction();
        try {
            unset($data['allowed_number_days']);
            $this->allowanceRepository->create($data);
            DB::commit();
            return $this->successResponse(['message' => trans('Thêm phụ cấp thành công!')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function update($id, AllowanceUpdateRequest $request)
    {
        $allowance = $this->allowanceRepository->find($id);

        if (! $allowance) {
            return $this->errorsResponse(['message' => trans('Phụ cấp không tồn tại.')], 422);
        }

        DB::beginTransaction();
        try {
            if (in_array($request->default, [1,2,3,4]) ) {
                $data = $request->only(['allowance_amount', 'allowed_number_days']);
            } else {
                $data = $request->all();
            }

            $allowance->update($data);
            DB::commit();
            return $this->successResponse(['allowance' => $allowance->refresh(), 'message' => trans('Sửa phụ cấp thành công !')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy($id)
    {
        $allowance = $this->allowanceRepository->find($id);

        if (! $allowance) {
            return $this->errorsResponse(['message' => trans('Phụ cấp không tồn tại.')], 422);
        }

        DB::beginTransaction();
        try {
            $allowance->update(['valid' => 0]);
            DB::commit();
            return $this->successResponse(['message' => trans('Xóa phụ cấp thành công !')]);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return $this->errorResponse($throwable->getMessage());
        }
    }
}
