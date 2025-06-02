<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SalaryGradeUpdateRequest;
use App\Models\HrmSalaryDetailStatisticObject;
use App\Models\TimeKeepingLogObject;
use App\Models\TimeKeepingShiftLog;
use App\Models\TimeKeepingStatisticObject;
use App\Repositories\Interfaces\IRequestTicketRepository;
use App\Repositories\Interfaces\ISalariesRepository;
use App\Repositories\Interfaces\ISalaryGradeRepository;
use App\Repositories\Interfaces\ITimekeepingRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\services\TimekeepingLogsStatisticService;
use App\Transformers\SalaryGradeTransformer;
use App\Transformers\TimeKeepingTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Nette\Utils\first;

class TimekeepingController extends Controller
{

    /**
     * @var ITimekeepingRepository
     */
    private $timekeepingRepository;

    /**
     * @var ISalariesRepository
     */
    private $salariesRepository;
    /**
     * @var IUserRepository
     */
    private $userRepository;

    private $timekeepingLogsStatisticService;

    public function __construct(ISalariesRepository $salariesRepository , IUserRepository $userRepository,
                                IRequestTicketRepository $requestTicketRepository, ITimekeepingRepository $timekeepingRepository
    )
    {
        $this->salariesRepository = $salariesRepository;
        $this->userRepository = $userRepository;
        $this->timekeepingLogsStatisticService = new TimekeepingLogsStatisticService($salariesRepository,$userRepository, $requestTicketRepository);
        $this->timekeepingRepository = $timekeepingRepository;
    }

    public function index()
    {
        $breadcrums = [
            'text' => trans('Chấm công')
        ];
//        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_PRODUCT);
        $data = [
            'breadcrums' => $breadcrums,
            'pageName' => trans('Chấm công'),
            'btnAdd' => true,
        ];
        return view('admin.timekeepings.index')->with($data);
    }

    public function showDetailTimekeeping(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $shift_id = $request->shift_id;
        $month = strlen($month) < 2 ? "0$month" : $month;
        $user = auth()->user();
        $salaryAttributesObject = new HrmSalaryDetailStatisticObject();

        $fullTimeWorkingShift = $this->setSalaryAttributesFullTimeWorkingShift($user, $month, $year, $salaryAttributesObject);

        return $this->successResponse($fullTimeWorkingShift, 200, false);
    }

    private function getActiveFullTimeWorkingShift($userId)
    {
        $record = DB::table('working_shift_settings')
            ->leftJoin(
                'working_shift_users',
                'working_shift_settings.id',
                '=',
                'working_shift_users.working_shift_setting_id'
            )->where([
                'working_shift_users.user_id' => $userId,
                'working_shift_settings.shift_type' => 1
            ])->first();

        return ! empty($record) ? $this->getWorkingShiftById($record->working_shift_setting_id) : null;
    }

    private function getWorkingShiftById( $shift_id)
    {
        $attributesKeys = ['work_number', 'wage_per_work', 'check_in_late', 'check_out_early', 'use_strict_timekeeping', 'use_free_timekeeping'];

        $weekdaysKeys = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        $weekdayAttributesKeys = ['is_working', 'shift_start_time', 'shift_end_time', 'upper_wage_percent'];

        $record = (array) DB::table('working_shift_settings')
            ->where('id', '=', $shift_id)
            ->first();

        if (! empty($record)) {
            $attributes = json_decode($this->array_pull_exists($record, 'attributes'), true);

            foreach ($attributesKeys as $attributesKey) {
                $record[$attributesKey] = $this->array_pull_exists($attributes, $attributesKey, null);
            }

            $shiftWeekdays = json_decode($record['shift_weekdays'], true);

            $record['shift_weekdays'] = [];

            foreach ($weekdaysKeys as $weekday) {
                $record['shift_weekdays'][$weekday] = [];

                foreach ($weekdayAttributesKeys as $attribute) {
                    $record['shift_weekdays'][$weekday][$attribute] = $shiftWeekdays[$weekday][$attribute] ?? null;
                }
            }
        }

        return $record;
    }

    private function setSalaryAttributesFullTimeWorkingShift( $user,  $salaryMonth,  $salaryYear, HrmSalaryDetailStatisticObject $salaryAttributesObject)
    {
        $firstDateOfMonth = date('Y-m-d', strtotime(date("$salaryYear-$salaryMonth-01")));
        $lastDateOfMonth = Carbon::create($salaryYear, $salaryMonth)->lastOfMonth()->toDateString();

        # Thông tin ca làm việc fulltime của user
        $workingShift = $this->getActiveFullTimeWorkingShift($user->id);

        if ($workingShift) {
            # Công chuẩn trong tháng
            # Tính số công theo lý thuyết (đi làm đủ) của nhân viên / một ca làm việc trong một khoảng thời gian
            $standardWorkInMonth = $this->countTheoryWorkingNumber($workingShift, $firstDateOfMonth, $lastDateOfMonth);

            # Thống kê ca làm việc
            $shiftStatistics = new TimeKeepingStatisticObject();
            $data = $this->timekeepingLogsStatisticService->getListInMonth([
                'month' => $salaryMonth,
                'year' => $salaryYear,
                'shift_id' => $workingShift['id']
            ], $user->id, $shiftStatistics);

            return array_merge((array)$shiftStatistics, ['standardWorkInMonth' => $standardWorkInMonth]);
//dd($shiftStatistics); Hiển thị thống kê
            #Công chuẩn
            $salaryAttributesObject->number_of_standard_working_days = $standardWorkInMonth;
            #Số ngày làm chính thức
            $salaryAttributesObject->number_of_official_working_days =  round($shiftStatistics->total_work_number, 2);
            #Số buổi đi muộn
            $salaryAttributesObject->checkin_late = $shiftStatistics->total_checkin_late;

            $salaryAttributesObject->checkout_early = $shiftStatistics->total_checkout_early;
        }
    }

    private function countTheoryWorkingNumber(array $shiftInfo,  $startDate,  $endDate)
    {
        $startDateTimestamp = strtotime($startDate);
        $endDateTimestamp = strtotime($endDate);

        $secondsInDay = 86400;

        $workNumber = 0;

        for($timestamp = $startDateTimestamp; $timestamp <= $endDateTimestamp; $timestamp += $secondsInDay) {
            $dayName = lcfirst(date('l', $timestamp));

            $isWorking = $shiftInfo['shift_weekdays'][$dayName]['is_working'] ?? 0;

            if ($isWorking)
            {
                $workNumber += round($shiftInfo['work_number'], 2);
            }
        }

        return $workNumber;
    }

    public function getInfoTimekeepings(Request $request)
    {
        if($request->shift_id == 0) {
//
            $query = DB::table('working_shift_users')
                ->select('working_shift_setting_id')
                ->where('user_id', auth()->user()->id);
            if($query->get()->count() > 1) {
                $data = [
                    'timeKeepings' => [],
                    'isCheckIn' =>  false,
                    'isComplete' => false,
                ];

                return response()->json($data);
            }

            $working_shift_setting_id = $query->first()->working_shift_setting_id;
        }

        $timeKeepings = $this->timekeepingRepository->model()
            ->where('valid', 1)
            ->where('user_id', auth()->user()->id)
            ->where('shift_id', $working_shift_setting_id ?? $request->shift_id)
            ->get()
            ->map(function ($item) {
                $item->check_in_time = $item->check_in ? Carbon::parse($item->check_in)->format('H:i:s') : '';
                $item->check_out_time = $item->check_out ? Carbon::parse($item->check_out)->format('H:i:s') : '';
                return $item;
            });


        $data = [
            'timeKeepings' => $timeKeepings,
            'isCheckIn' => $this->timekeepingRepository->model()
                ->where('user_id', auth()->user()->id)
                ->where('shift_id',$working_shift_setting_id ?? $request->shift_id)->where('valid', 1)->whereDate('checkin_date', now()->format('Y-m-d'))->exists(),
            'isComplete' => $this->timekeepingRepository->model()
                ->where('user_id', auth()->user()->id)
                ->where('shift_id',$working_shift_setting_id ?? $request->shift_id)->where('valid', 1)->whereDate('checkin_date', now()->format('Y-m-d'))
                ->whereNotNull('check_in')
                ->whereNotNull('check_out')
                ->exists(),
        ];

        $this->setTransformer(new TimeKeepingTransformer());

        return response()->json($data);
    }

    private function handleMakeTimeKeepingLogObject($workingShift)
    {

        $weekday = strtolower(date('l'));

        $timekeepingLogObjectData = [
            'shift' => new TimeKeepingShiftLog([
                'today' => $weekday,
                'shift_weekday' => (object) $workingShift->shift_weekdays->{$weekday},
                'info' => (object) [
                    'shift_id' => $workingShift->id,
                    'work_number' => $workingShift->attributes->work_number,
                    'check_in_late' => $workingShift->attributes->check_in_late,
                    'check_out_early' => $workingShift->attributes->check_out_early,
                    'use_strict_timekeeping' => $workingShift->attributes->use_strict_timekeeping,
                    'use_free_timekeeping' => $workingShift->attributes->use_free_timekeeping,
                    'shift_type' => $workingShift->shift_type,
                    'shift_title' => $workingShift->shift_title,
                    'description' => $workingShift->description,
                ]
            ]),
        ];

        return $timekeepingLogObjectData;
    }

    public function update(Request $request)
    {
        $data = $request->all();

        if(! $request->shift_id) {
            return $this->errorsResponse(['shift_id' => ["Vui lòng chọn ca chấm công."]], 422);
        }

        $isCheckin = $request->is_checkin;
        $shift = DB::table('working_shift_settings')->where('id', $request->shift_id)->first();
        $shift->shift_weekdays = $shift->shift_weekdays ? json_decode($shift->shift_weekdays): null;
        $shift->attributes = $shift->attributes ? json_decode($shift->attributes): null;

        $logs = $this->handleMakeTimeKeepingLogObject($shift);

        DB::beginTransaction();
        try {
            if($isCheckin == false) {
                $attributes = [
                  'user_id'  => auth()->user()->id,
                  'check_in'  => date('Y-m-d H:i:s'),
                  'check_out'  => null,
                  'checkin_date'  => date('Y-m-d'),
                  'shift_id'  => $request->shift_id,
                   'logs' => json_encode($logs)
                ];

                $this->timekeepingRepository->create($attributes);
                $message = trans('Bạn đã chấm công vào thành công!');

            }else {
                $record =  $this->timekeepingRepository->model()
                    ->where('user_id', auth()->user()->id)
                    ->where('shift_id', $request->shift_id)
                    ->where('valid', 1)->whereDate('checkin_date', now()->format('Y-m-d'))->first();

                $record->update([
                    'check_out'  => date('Y-m-d H:i:s'),
                ]);

                $message = trans('Bạn đã chấm ra vào thành công!');
            }

            DB::commit();
            return $this->successResponse(['message' => $message]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function array_pull_exists(array &$array,  $key, $default = null)
    {
        if (array_key_exists($key, $array)) {
            return $this->array_pull($array, $key);
        }

        return $default;
    }

    public function array_pull(array &$array,  $key)
    {
        $value = $array[$key];

        unset($array[$key]);

        return $value;
    }
}
