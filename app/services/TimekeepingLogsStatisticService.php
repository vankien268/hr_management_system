<?php


namespace App\services;


use App\Models\RequestTicket;
use App\Models\RequestTicketResult;
use App\Models\ShiftWeekdayObject;
use App\Models\StatisticWorkingShiftObject;
use App\Models\TimeKeepingStatisticObject;
use App\Models\workflow;
use App\Repositories\Interfaces\IRequestTicketRepository;
use App\Repositories\Interfaces\ISalariesRepository;
use App\Repositories\Interfaces\IUserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TimekeepingLogsStatisticService
{

    const WORKFLOW_TYPES = [
        'annual_leave' => 'Nghỉ phép năm',
        'regime_leave' => 'Nghỉ chế độ',
        'business_travel' => 'Đi công tác',
        'working_out_of_the_office' => 'Làm việc ngoài văn phòng',
        'unpaid_leave' => 'Nghỉ không lương',
        'arriving_late' => 'Xin đi muộn',
        'leave_early' => 'Xin về sớm',
        'forgot_timekeeping' => 'Quên chấm công',
    ];

    /**
     * @var ISalariesRepository
     */
    private $salariesRepository;
    /**
     * @var IUserRepository
     */
    private $userRepository;
    /**
     * @var IRequestTicketRepository
     */
    private $requestTicketRepository;

    public function __construct(ISalariesRepository $salariesRepository, IUserRepository $userRepository, IRequestTicketRepository $requestTicketRepository
    )
    {

        $this->salariesRepository = $salariesRepository;
        $this->userRepository = $userRepository;
        $this->requestTicketRepository = $requestTicketRepository;
    }

    public function getSymbolFields()
    {
        return [
            'monday' => 'T2', 'tuesday' => 'T3', 'wednesday' => 'T4',
            'thursday' => 'T5', 'friday' => 'T6', 'saturday' => 'T7', 'sunday' => 'CN'
        ];
    }

    private function handleRequestTicketResult( $userId,  $startDate,  $endDate,  $shiftId)
    {
        $requestTicketResultCollection = DB::table('request_ticket_results')
            ->leftJoin('request_tickets', 'request_ticket_results.request_ticket_id', '=', 'request_tickets.id')
            ->where('request_tickets.created_by', $userId)
            ->whereDate('request_ticket_results.leave_day', '>=', $startDate)
            ->whereDate('request_ticket_results.leave_day', '<=', $endDate)
            ->where('request_ticket_results.working_shift_id', $shiftId)
            ->where('request_tickets.request_status', RequestTicket::STATUS_APPROVED)
            ->get();

        $requestTicketResults = [];


        foreach ($requestTicketResultCollection as $requestTicketResult){
            $date = date('Y-m-d', strtotime($requestTicketResult->leave_day));
            $requestTicketResults[$date.'/'.$requestTicketResult->id] = $requestTicketResult;
        }

        return $requestTicketResults;
    }

    public function getListInMonth( $dataRequest,  $userId, TimeKeepingStatisticObject $statisticObject)
    {
        $year = $dataRequest['year'] ?? null;
        $month = $dataRequest['month'] ?? null;
        $month = strlen($month) < 2 ? "0$month" : $month;
        $shiftIds = $dataRequest['shift_id'];
        $shiftIds = is_array($shiftIds) ? $shiftIds : [$shiftIds];

        $firstDayOfMonth = 1;
        $lastDayOfMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        $startDate = "{$year}-{$month}-0{$firstDayOfMonth}";
        $endDate = "{$year}-{$month}-{$lastDayOfMonth}";

        $user = $this->userRepository->model()
            ->where('id', $userId)->first();

        $requestTicketResults = [];

        foreach ($shiftIds as $shiftId) {

            $timeKeepingListOfMonth = [];

            $weekDaySymbols = $this->getSymbolFields();

            $shiftWeekdayObject = new ShiftWeekdayObject();

            $shiftObject = new StatisticWorkingShiftObject();

            $requestTicketResults = array_merge($requestTicketResults, $this->handleRequestTicketResult($userId, $startDate, $endDate, $shiftId));

            $requestTicketResultOtherLeave = 0;
            $requestTicketResultUnpaidLeave = 0;
            $requestTicketResultAnnualLeave = 0;

            foreach ($requestTicketResults as $requestTicketResult) {
                if ($requestTicketResult->result_type === RequestTicketResult::UNPAID_LEAVE) {
                    $requestTicketResultUnpaidLeave++;
                } elseif ($requestTicketResult->result_type === RequestTicketResult::ANNUAL_LEAVE) {
                    $requestTicketResultAnnualLeave++;
                } elseif (in_array($requestTicketResult->result_type, [RequestTicketResult::REGIME_LEAVE, RequestTicketResult::BUSINESS_TRAVEL, RequestTicketResult::WORKING_OUT_OF_THE_OFFICE])) {
                    $requestTicketResultOtherLeave++;
                }
            }

            $timeKeepingLogCollection = DB::table('timekeepings')
                ->where('user_id', $userId)
                ->where('shift_id', $shiftId)
                ->whereDate('checkin_date', '>=', $startDate)
                ->whereDate('checkin_date', '<=', $endDate)
                ->get();

            foreach ($timeKeepingLogCollection as $timeKeepingLog) {

                $logs = $timeKeepingLog->logs ? json_decode($timeKeepingLog->logs): null;

                $checkinTime = ($timeKeepingLog->check_in !== null)
                    ? date('H:i:s', strtotime($timeKeepingLog->check_in)) : null;

                $checkoutTime =  ($timeKeepingLog->check_out !== null)
                    ? date('H:i:s', strtotime($timeKeepingLog->check_out)) : null;

                # số phút đi muộn
                $checkinLateMinutes = 0;

                # số phút về sớm
                $checkoutEarlyMinutes = 0;

                # số phút làm việc thực tế
                $workingHours = 0;

                # số công thực tế
                $workNumber = 0;

                # Loại phiếu xin phép (nếu có)
                $requestIds = [];
                $requestTicketType = '';

                # Nếu có log xin phép đi muộn / về sớm / quên chấm công, thì lấy thời gian bắt đầu / kết thúc ca làm thời gian checkin checkout
                foreach ($requestTicketResults as $key => $requestTicketResult) {
                    if(str_contains($key, $timeKeepingLog->checkin_date)){


                        $requestTicketResult = $requestTicketResults[$key];
                        if($requestTicketResult->result_type == Workflow::WORKFLOW_TYPE_ARRIVING_LATE){
                            $checkinTime = $logs->shift->shift_weekday->shift_start_time ?? null;
                        }

                        if($requestTicketResult->result_type == Workflow::WORKFLOW_TYPE_LEAVE_EARLY){
                            $checkoutTime = $logs->shift->shift_weekday->shift_end_time ?? null;
                        }

                        if($requestTicketResult->result_type == Workflow::WORKFLOW_TYPE_FORGOT_TIMEKEEPING){
                            $checkinTime = $logs->shift->shift_weekday->shift_start_time ?? null;
                            $checkoutTime = $logs->shift->shift_weekday->shift_end_time ?? null;
                        }

                        $requestTicketType = $requestTicketResult->result_type;
                        $requestIds[] = $requestTicketResult->request_ticket_id;
                    }
                }

                if ($checkinTime !== null && $checkoutTime !== null) {
                    $workingHours = round(((strtotime($checkoutTime) - strtotime($checkinTime)) / 60) / 60, 2);
                }

                $holidayInfo = null;

                # Thống kê
                $shiftWeekdayObject->populate((array) $logs->shift->shift_weekday ?? []);

                $shift = $logs->shift->info ?? null;

                //Thời gian cho phép đi muộn
                $checkInLate = $shift ? (float)$shift->check_in_late * 60 : null;
                $checkOutEarly = $shift ? (float)$shift->check_out_early * 60 : null;

                $weekdayStartTimeStamp = ($shiftWeekdayObject->shift_start_time !== null)
                    ? strtotime($shiftWeekdayObject->shift_start_time) : null;

                $weekdayEndTimeStamp = ($shiftWeekdayObject->shift_end_time !== null)
                    ? strtotime($shiftWeekdayObject->shift_end_time) : null;

                # Thống kê đi sớm, đi muộn
                if ($checkinTime !== null && $weekdayStartTimeStamp !== null) {
                    $earlyMinutes = round(($weekdayStartTimeStamp + $checkInLate - strtotime($checkinTime)) / 60, 2);

                    if ($earlyMinutes > 0) {
                        $statisticObject->checkin_early_minutes += $earlyMinutes;
                        ++ $statisticObject->total_checkin_early;
                    } else if($earlyMinutes == 0){

                    } else {
                        $checkinLateMinutes = - $earlyMinutes;
                        $statisticObject->checkin_late_minutes += - $earlyMinutes;
                        ++ $statisticObject->total_checkin_late;
                    }
                }

                # Thống kê về sớm, về muộn
                if ($checkoutTime !== null && $weekdayEndTimeStamp !== null) {
                    $earlyMinutes = round(($weekdayEndTimeStamp - $checkOutEarly - strtotime($checkoutTime)) / 60, 2);

                    if ($earlyMinutes > 0) {
                        $checkoutEarlyMinutes = $earlyMinutes;
                        $statisticObject->checkout_early_minutes += $earlyMinutes;
                        ++ $statisticObject->total_checkout_early;
                    } else if($earlyMinutes == 0){

                    } else {
                        $statisticObject->checkout_late_minutes += - $earlyMinutes;
                        ++ $statisticObject->total_checkout_late;
                    }
                }

                # Thống kê tổng công
                if (
                    $shiftWeekdayObject->is_working === 1
                    && $checkinTime !== null
                    && $checkoutTime !== null
                ) {

                    $shiftObject->setInputData((array) $logs->shift->info ?? []);

                    $shiftWorkingTime = (strtotime($shiftWeekdayObject->shift_end_time) - strtotime($shiftWeekdayObject->shift_start_time)) / 60;
                    $shiftWorkingTime = round($shiftWorkingTime, 2);

                    $shiftWorkNumber = $shiftObject->work_number;

                    if ($shiftObject->use_strict_timekeeping === 1) {
                        if (
                            (
                                strtotime($checkinTime) <= (strtotime($shiftWeekdayObject->shift_start_time) + ($shiftObject->check_in_late * 60))
                            )
                            && (
                                strtotime($checkoutTime) >= (strtotime($shiftWeekdayObject->shift_end_time) - ($shiftObject->check_out_early * 60))
                            )
                        ) {
                            $workNumber = $shiftObject->work_number;
                        }
                    } else {
                        # Quy tắc chấm công nghiêm ngặt: đúng giờ mới được tính công
                        if ($shiftObject->use_strict_timekeeping === 0) {

                            # Quy tắc chấm công tự do: tính công dựa vào thời gian làm việc thực tế
                            # Chấm công theo giờ: checkin -> checkout
                            if ($shiftObject->use_free_timekeeping === 1) {
                                $userWorkingTime = round((strtotime($checkoutTime) - strtotime($checkinTime)) / 60, 2);
                            } else {
                                if(strtotime($checkinTime) < strtotime($shiftWeekdayObject->shift_start_time)){
                                    $timeIn = $shiftWeekdayObject->shift_start_time;
                                }else{
                                    $timeIn = $checkinTime;
                                }

                                # Quy tắc chấm công tự do: tính công dựa vào thời gian làm việc thực tế [checkin -> checkout]
                                $userWorkingTime = round((strtotime($checkoutTime) - strtotime($timeIn)) / 60, 2);

                                # Chấm công theo giờ: checkin -> shift end time
                                if (
                                    $shiftObject->use_free_timekeeping === 0
                                    && (strtotime($checkoutTime) >= (strtotime($shiftWeekdayObject->shift_end_time) - ($shiftObject->check_out_early * 60)))
                                ) {
                                    $userWorkingTime = round((strtotime($shiftWeekdayObject->shift_end_time) - strtotime($timeIn)) / 60, 2);
                                }
                            }

                            $workNumber = round(($userWorkingTime * $shiftWorkNumber) / ($shiftWorkingTime ?: 1), 2);

                            if ($workNumber < 0) {
                                $workNumber = 0;
                            }
                        }
                    }

                    foreach ($requestTicketResults as $key => $requestTicketResult) {
                        if(str_contains($key, $timeKeepingLog->checkin_date)){
                            /* @var RequestTicketResult $requestTicketResult */
                            $requestTicketResult = $requestTicketResults[$key];
                            if(!in_array($requestTicketResult->result_type, [Workflow::WORKFLOW_TYPE_ARRIVING_LATE, Workflow::WORKFLOW_TYPE_LEAVE_EARLY, Workflow::WORKFLOW_TYPE_UNPAID_LEAVE])){
                                if(in_array($requestTicketResult->result_type, [Workflow::WORKFLOW_TYPE_ANNUAL_LEAVE, Workflow::WORKFLOW_TYPE_UNPAID_LEAVE])){
                                    $workNumber += $requestTicketResult->result_type;
                                }else{
                                    $workNumber = $requestTicketResult->number_leave_day;
                                }
                            }
                        }
                    }

                    $statisticObject->total_work_number += $workNumber;
                }

                $dayTitle = lcfirst(date('l', strtotime($timeKeepingLog->checkin_date)));

                $daySymbol = $weekDaySymbols[$dayTitle] ?? 'unknown';

                $timeKeepingListOfMonth[$timeKeepingLog->checkin_date] = [
                    'id' => $timeKeepingLog->id,
                    'check_in' => ($checkinTime !== null) ? $checkinTime : '',
                    'check_out' => ($checkoutTime !== null) ? $checkoutTime : '',
                    'date_title' => date('d/m', strtotime($timeKeepingLog->checkin_date)) . '-' . $daySymbol,
                    'check_in_late_minutes' => round($checkinLateMinutes),
                    'check_out_early_minutes' => round($checkoutEarlyMinutes),
                    'working_hours' => $workingHours,
                    'work_number' => $workNumber,
                    'result_type' =>  self::WORKFLOW_TYPES[$requestTicketType] ?? "",
                    'request_ticket_id' => $requestIds
                ];
            }
        }

        $daysOfMonth = [];
        $secondsInDay = 86400;
        $totalFirstDayInMonthToNow = 0;

        $shiftsInfo = DB::table('working_shift_settings')->whereIn('id', $shiftIds)->get();

        foreach ($shiftsInfo as $shiftInfo) {

            for ($day = $firstDayOfMonth; $day <= $lastDayOfMonth; $day++) {
                $dateTimestamp = strtotime("{$year}-{$month}-{$day}");

                $date = date('Y-m-d', $dateTimestamp);

                $dayTitle = lcfirst(date('l', $dateTimestamp));

                $daySymbol = $weekDaySymbols[$dayTitle] ?? 'unknown';

                if (empty($timeKeepingListOfMonth[$date])) {

                    # Loại phiếu xin phép (nếu có)
                    $requestTicketType = '';
                    $requestIds = [];
                    $workNumber = 0;

                    foreach ($requestTicketResults as $key => $requestTicketResult) {

                        # Nếu có log xin phép
                        if(str_contains($key, $date)){

                            /* @var RequestTicketResult $requestTicketResult */
                            $requestTicketResult = $requestTicketResults[$key];
                            # Nếu có log xin phép không phải xin đi muộn / về sớm
                            if(!in_array($requestTicketResult->result_type, [Workflow::WORKFLOW_TYPE_ARRIVING_LATE, Workflow::WORKFLOW_TYPE_LEAVE_EARLY, Workflow::WORKFLOW_TYPE_UNPAID_LEAVE])){
                                if(in_array($requestTicketResult->result_type, [Workflow::WORKFLOW_TYPE_ANNUAL_LEAVE, Workflow::WORKFLOW_TYPE_FORGOT_TIMEKEEPING])){
                                    $workNumber += $requestTicketResult->number_leave_day;
                                }else{
                                    $workNumber = $requestTicketResult->number_leave_day;
                                }
                            }

                            $requestTicketType = $requestTicketResult->result_type;
                            $requestIds[] = $requestTicketResult->request_ticket_id;
                            # Nếu số công = 0 thì sẽ là ngày nghỉ định => không hiển thị (áp dụng cho phép năm)
//                            if (
//                                $requestTicketResult->resultType() === Workflow::WORKFLOW_TYPE_ANNUAL_LEAVE
//                            ) {
//                                $requestTicketType = '';
//                            }

                            $statisticObject->total_work_number += $workNumber;
                        }
                    }

                    $daysOfMonth[$date] = [
                        'check_in' => null,
                        'check_out' => null,
                        'date_title' => date('d/m', $dateTimestamp) . '-' . $daySymbol,
                        'check_in_late_minutes' => null,
                        'check_out_early_minutes' => null,
                        'working_hours' => null,
                        'work_number' => $workNumber,
                        'is_holiday' => isset($holidays[$dateTimestamp]),
                        'result_type' => self::WORKFLOW_TYPES[$requestTicketType] ?? "",
                        'request_ticket_id' => $requestIds
                    ];
                } else {
                    $daysOfMonth[$date] = $timeKeepingListOfMonth[$date];
                    $statisticObject->total_working_days++;
                }
            }

            $statisticObject->total_excused_absence = $requestTicketResultUnpaidLeave + $requestTicketResultAnnualLeave + $requestTicketResultOtherLeave;
            $statisticObject->total_unexcused_absence = max($totalFirstDayInMonthToNow - $statisticObject->total_work_number - $requestTicketResultUnpaidLeave - $requestTicketResultAnnualLeave - $requestTicketResultOtherLeave, 0);
        }

        $statisticObject->round();

        return $daysOfMonth;
    }
}
