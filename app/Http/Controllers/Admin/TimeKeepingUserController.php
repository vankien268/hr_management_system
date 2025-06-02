<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TimeKeepingShiftLog;
use App\Repositories\Interfaces\ITimekeepingRepository;
use App\Transformers\TimeKeepingTransformer;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimeKeepingUserController extends Controller
{
    /**
     * @var ITimekeepingRepository
     */
    private $timekeepingRepository;

    public function __construct(ITimekeepingRepository $timekeepingRepository)
    {

        $this->timekeepingRepository = $timekeepingRepository;
    }

    public function index()
    {
        $breadcrums = [
            'text' => trans('Quản lý ca chấm công theo ca')
        ];
//        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_PRODUCT);
        $data = [
            'breadcrums' => $breadcrums,
            'pageName' => trans('Quản lý ca chấm công theo ca'),
            'btnAdd' => true,
        ];
        return view('admin.timekeeping-users.index')->with($data);
    }

    public function getInfoTimekeepingUsers(Request $request)
    {
        $nameAndCode = $request->nameAndCode;

        $month = $request->month;

        $timeKeepings = $this->timekeepingRepository->model()
            ->select(['timekeepings.*','contacts.full_name','contacts.contact_code'])
            ->join('contacts', 'contacts.user_id', '=', 'timekeepings.user_id')
            ->where(function ($query) use ($nameAndCode, $month){
                if($nameAndCode) {
                    $query->where('contacts.full_name', 'like', '%'.$nameAndCode.'%')
                        ->orwhere('contacts.contact_code', 'like', '%'.$nameAndCode.'%');
                }
            })

            ->where( function ($query) use ($request) {
                $query->where('timekeepings.shift_id', $request->shift_id);
            })
            ->get()->map(function ($item) {
                $item->check_in_time =  $item->check_in ?  Carbon::parse($item->check_in)->format('H:i'): "";
                $item->check_out_time =  $item->check_out ?  Carbon::parse($item->check_out)->format('H:i'): "";
                return $item;
            });

        $date_in_month_label = [];

        // Danh sách thứ trong tuần
        $dayOfWeekMap = [
            0 => 'CN', // Chủ nhật
            1 => 'T2',
            2 => 'T3',
            3 => 'T4',
            4 => 'T5',
            5 => 'T6',
            6 => 'T7',
        ];

        $month = $request->month ?? now()->format('Y-m');


        [$year, $monthNumber] = explode('-', $month);


        $start = Carbon::createFromDate($year, $monthNumber, 1)->startOfMonth();
        $end = Carbon::createFromDate($year, $monthNumber, 1)->endOfMonth();

        $period = CarbonPeriod::create($start, $end);

        $date_in_month_label = [];
        $user_timekeeping_in_month = [];

        foreach ($period as $date) {
            $key = $date->format('Y-m-d');
            $day = $date->format('d/m');
            $dow = $dayOfWeekMap[$date->dayOfWeek];

            $date_in_month_label[$key] = "{$day}-{$dow}";
        }


        foreach ($timeKeepings as $timeKeeping) {
            foreach ($date_in_month_label as $date => $label) {
                $user_timekeeping_in_month[$timeKeeping->user_id]['full_name'] = $timeKeeping->full_name;
                $user_timekeeping_in_month[$timeKeeping->user_id]['user_id'] = $timeKeeping->user_id;
                $user_timekeeping_in_month[$timeKeeping->user_id]['contact_code'] = $timeKeeping->contact_code;

                $user_timekeeping_in_month[$timeKeeping->user_id]['months'][$date] = [
                    'check_in' => '',
                    'check_out' => '',
                    'checkin_date' => $date,
                    'check_in_time' => '',
                    'check_out_time' => '',
                ];
            }
        }


        foreach ($timeKeepings as $timeKeeping) {
            $date = $timeKeeping->checkin_date;
            $user_id = $timeKeeping->user_id;

            if (isset($user_timekeeping_in_month[$user_id]['months'][$date])) {
                $user_timekeeping_in_month[$user_id]['months'][$date]['check_in'] = $timeKeeping->check_in;
                $user_timekeeping_in_month[$user_id]['months'][$date]['check_out'] = $timeKeeping->check_out;
                $user_timekeeping_in_month[$user_id]['months'][$date]['check_in_time'] = $timeKeeping->check_in_time;
                $user_timekeeping_in_month[$user_id]['months'][$date]['check_out_time'] = $timeKeeping->check_out_time;
            }
        }


        return response()->json([
            'date_in_month_label' => $date_in_month_label,
            'user_timekeeping_in_month' => array_values($user_timekeeping_in_month)
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->all();

        if(! $request->shift_id) {
            return $this->errorsResponse(['shift_id' => ["Vui lòng chọn ca chấm công."]], 422);
        }

        $errors = [];

        if(! $request->check_in) {
            $errors['check_in'] = ["Thời gian vào không bỏ trống."];
        }

        if(! $request->check_out) {
            $errors['check_out'] = ["Thời gian ra không bỏ trống."];
        }

        if($errors) {
            return $this->errorsResponse($errors, 422);
        }

        DB::beginTransaction();
        try {

            $record =  $this->timekeepingRepository->model()
                ->where('user_id', $request->user_id)
                ->where('shift_id', $request->shift_id)
                ->where('valid', 1)->whereDate('checkin_date', $request->checkin_date)
                ->first();

            $shift = DB::table('working_shift_settings')->where('id', $request->shift_id)->first();
            $shift->shift_weekdays = $shift->shift_weekdays ? json_decode($shift->shift_weekdays): null;
            $shift->attributes = $shift->attributes ? json_decode($shift->attributes): null;

            $logs = $this->handleMakeTimeKeepingLogObject($shift, $request->checkin_date);


            if(! $record) {

                $attributes = [
                    'user_id'  =>  $request->user_id,
                    'check_in'  => Carbon::createFromFormat('Y-m-d H:i',  $request->checkin_date.' '. $request->check_in),
                    'check_out'  => Carbon::createFromFormat('Y-m-d H:i',  $request->checkin_date.' '. $request->check_out),
                    'checkin_date'  => $request->checkin_date,
                    'shift_id'  => $request->shift_id,
                    'logs' => json_encode($logs)
                ];

                $this->timekeepingRepository->create($attributes);

            }else {

                $attributes = [
                    'check_in'  => Carbon::createFromFormat('Y-m-d H:i',  $request->checkin_date.' '. $request->check_in),
                    'check_out'  => Carbon::createFromFormat('Y-m-d H:i',  $request->checkin_date.' '. $request->check_out),
                    'logs' => json_encode($logs)
                ];

                $record->update($attributes);
            }

            DB::commit();
            return $this->successResponse(['message' => "Cập nhật chấm công thành công."]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    private function handleMakeTimeKeepingLogObject($workingShift, $checkinDate)
    {

        $weekday = strtolower(date('l', strtotime($checkinDate)));

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
}
