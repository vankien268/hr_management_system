<?php


namespace App\Http\Controllers\Admin;


use App\Enums\SystemPermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\InternalFundUpdateRequest;
use App\Http\Requests\UserLeaveDayStoreRequest;
use App\Models\InitValue;
use App\Repositories\Interfaces\IInitValueRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function App\Helper\check_user_permission;

class UserLeaveDayController extends Controller
{
    private $initValueRepository;

    public function __construct(IInitValueRepository $initValueRepository)
    {
        $this->initValueRepository = $initValueRepository;
    }

    public function index()
    {
        $breadcrums = [
            'text' => trans('Cấu hình nghỉ phép')
        ];
//        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_PRODUCT);
        $data = [
            'breadcrums' => $breadcrums,
            'pageName' => trans('Cấu hình nghỉ phép'),
            'btnAdd' => true,
        ];
        return view('admin.user-leave-days.index')->with($data);
    }

    public function getInfoNumberOfMonthlyLeaveDays(Request $request)
    {
        $numberOfMonthlyLeaveDays = $this->initValueRepository->model()
            ->where('init_name', 'number_of_monthly_leave_days')
            ->first();

        $data = [
            'number_of_monthly_leave_days' => $numberOfMonthlyLeaveDays ? $numberOfMonthlyLeaveDays->init_value : 0,
        ];

        return response()->json($data);
    }

    public function update(UserLeaveDayStoreRequest $request)
    {

        if(! check_user_permission(SystemPermissionEnum::EDIT_USER_LEAVE_DAYS)) {
            return $this->errorsResponse(['message' => trans('Bạn không có quyền sửa cấu hình nghỉ phép.')], 403);
        }

        $data = $request->all();
        DB::beginTransaction();
        try {

            $numberOfMonthlyLeaveDays = $this->initValueRepository->model()
                ->where('init_name', 'number_of_monthly_leave_days')
                ->first();

            if(! $numberOfMonthlyLeaveDays) {
                $this->initValueRepository->create([
                    'init_name' => 'number_of_monthly_leave_days',
                    'init_value' => $data['number_of_monthly_leave_days'] ?? 0
                ]);
            }else {
                $numberOfMonthlyLeaveDays->update([
                    'init_value' => $data['number_of_monthly_leave_days'] ?? 0
                ]);
            }

            DB::commit();
            return $this->successResponse(['message' => trans('Cập nhật cấu hình nghỉ phép thành công!')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }
}
