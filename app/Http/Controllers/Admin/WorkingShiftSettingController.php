<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SystemPermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\AllowanceStoreRequest;
use App\Http\Requests\AllowanceUpdateRequest;
use App\Http\Requests\WorkingShiftSettingStoreRequest;
use App\Http\Requests\WorkingShiftSettingUpdateRequest;
use App\Repositories\Interfaces\IAllowanceRepository;
use App\Repositories\Interfaces\IWorkingShiftSettingRepository;
use App\Transformers\AllowanceTransformer;
use App\Transformers\WorkingShiftSettingTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function App\Helper\check_user_permission;

class WorkingShiftSettingController extends Controller
{

    /**
     * @var IWorkingShiftSettingRepository
     */
    private $workingShiftSettingRepository;

    public function __construct(IWorkingShiftSettingRepository $workingShiftSettingRepository)
    {
        $this->workingShiftSettingRepository = $workingShiftSettingRepository;
    }

    public function index()
    {
        $breadcrums = [
            'text' => trans('Thiết lập ca làm việc')
        ];

        $data = [
            'breadcrums' => $breadcrums,
            'pageName' => trans('Thiết lập ca làm việc'),
            'btnAdd' => true,
        ];

        return view('admin.working-shift-settings.index')->with($data);
    }

    public function getAllWorkingShiftSettings(Request $request)
    {
        $isTimekeeping = $request->is_timekeeping;

        $query = $this->workingShiftSettingRepository->model()
            ->where('valid', 1);

        if($isTimekeeping) {
            $working_shift_setting_ids = DB::table('working_shift_users')
                ->select('working_shift_setting_id')
                ->where('user_id', auth()->user()->id)->pluck('working_shift_setting_id')->toArray();

            $query = $query->whereIn('id', $working_shift_setting_ids);

        }

        $workingShiftSettings = $query->orderByDesc('id')->get()
            ->map(function ($item) {
                $item->working_shift_users = DB::table('working_shift_users')
                    ->select('user_id')
                    ->where('working_shift_setting_id', $item->id)->pluck('user_id')->toArray();

                $item->users = DB::table('users')
                    ->whereIn('id',  $item->working_shift_users)->get()->toArray();

                return $item;
            });

        $this->setTransformer(new WorkingShiftSettingTransformer());

        return $this->responseCollection(
            $workingShiftSettings,
            200
        );
    }

    public function store(WorkingShiftSettingStoreRequest $request)
    {
        $data = $request->all();

        DB::beginTransaction();
        try {
            $data['attributes'] = $data['attributes'] ? json_encode($data['attributes']) : null;

            $data['shift_weekdays'] = $data['shift_weekdays'] ? json_encode($data['shift_weekdays']) : null;

            $working_shift_users = $data['working_shift_users'] ?? [];

            $shiftIds =  $this->workingShiftSettingRepository->model()->where('shift_type', 1)->get()->pluck('id')->toArray();

            $errors = [];

            foreach ($working_shift_users as $user) {

               $working_shift_user = DB::table('working_shift_users')
                    ->whereIn('working_shift_setting_id', $shiftIds)
                    ->where('user_id', $user['id'])->first();

               if($working_shift_user) {
                   $errors[] = $user['name']. "(".$user['username'].")";
               }
            }

            if($errors) {
                return $this->errorsResponse([ 'working_shift_users' => [implode(", ", $errors). " đã được thêm vào thiết lập chấm công khác."]], 422);
            }

            unset($data['id']);

           $shift = $this->workingShiftSettingRepository->create($data);

            $dataShiftUsers = [];

            foreach ($working_shift_users as $user) {
                $dataShiftUsers[] = [
                    'user_id' => $user['id'],
                    'working_shift_setting_id' => $shift->id,
                ];
            }

            DB::table('working_shift_users')->insert($dataShiftUsers);

            DB::commit();
            return $this->successResponse(['message' => trans('Thiết lập ca làm việc thành công!')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function update($id, WorkingShiftSettingUpdateRequest $request)
    {
        $workingShiftSetting = $this->workingShiftSettingRepository->find($id);

        if (! $workingShiftSetting) {
            return $this->errorsResponse(['message' => trans('Ca làm việc không tồn tại.')], 422);
        }
        $data = $request->all();
        DB::beginTransaction();
        try {

            $data['attributes'] = $data['attributes'] ? json_encode($data['attributes']) : null;

            $data['shift_weekdays'] = $data['shift_weekdays'] ? json_encode($data['shift_weekdays']) : null;

            $working_shift_users = $data['working_shift_users'] ?? [];

            unset($data['id']);

            $workingShiftSetting->update($data);

            DB::table('working_shift_users')
                ->select('user_id')
                ->where('working_shift_setting_id', $workingShiftSetting->id)->delete();

            $dataShiftUsers = [];

            foreach ($working_shift_users as $user) {
                $dataShiftUsers[] = [
                    'user_id' => $user['id'],
                    'working_shift_setting_id' => $workingShiftSetting->id,
                ];
            }

            DB::table('working_shift_users')->insert($dataShiftUsers);

            DB::commit();
            return $this->successResponse(['workingShiftSetting' => $workingShiftSetting->refresh(), 'message' => trans('Sửa thiết lập ca làm việc thành công!')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy($id)
    {
        $workingShiftSetting = $this->workingShiftSettingRepository->find($id);

        if (! $workingShiftSetting) {
            return $this->errorsResponse(['message' => trans('Ca làm việc không tồn tại.')], 422);
        }

        DB::beginTransaction();
        try {
            $workingShiftSetting->update(['valid' => 0]);
            DB::commit();
            return $this->successResponse(['message' => trans('Xóa ca làm việc thành công!')]);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return $this->errorResponse($throwable->getMessage());
        }
    }
}
