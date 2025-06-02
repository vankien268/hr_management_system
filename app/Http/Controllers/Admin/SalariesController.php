<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SystemPermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepartmentStoreRequest;
use App\Http\Requests\DepartmentUpdateRequest;
use App\Http\Requests\salaryStoreRequest;
use App\Http\Requests\salaryUpdateRequest;
use App\Models\Allowance;
use App\Models\HrmSalaryDetail;
use App\Models\HrmSalaryDetailStatisticObject;
use App\Models\InitValue;
use App\Models\Salaries;
use App\Models\TimeKeepingStatisticObject;
use App\Repositories\DepartmentRepository;
use App\Repositories\Interfaces\IRequestTicketRepository;
use App\Repositories\Interfaces\ISalariesRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\services\TimekeepingLogsStatisticService;
use App\Transformers\SalaryContactTransformer;
use App\Transformers\SalaryTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function App\Helper\check_user_permission;

class SalariesController extends Controller
{
    /**
     * @var ISalariesRepository
     */
    private $salariesRepository;
    /**
     * @var IUserRepository
     */
    private $userRepository;

    private $timekeepingLogsStatisticService;

    const WORKING_SHIFT_TYPE_FULL_TIME = 1;
    const WORKING_SHIFT_TYPE_PART_TIME = 0;
    /**
     * @var IRequestTicketRepository
     */
    private $requestTicketRepository;

    public function __construct(ISalariesRepository $salariesRepository , IUserRepository $userRepository,
    IRequestTicketRepository $requestTicketRepository
    )
    {
        $this->salariesRepository = $salariesRepository;
        $this->userRepository = $userRepository;
        $this->timekeepingLogsStatisticService = new TimekeepingLogsStatisticService($salariesRepository,$userRepository, $requestTicketRepository);
        $this->requestTicketRepository = $requestTicketRepository;
    }

    private function prepareHrmSalaryContactsToCreate(Salaries $hrmSalary, int $userId = null)
    {

        $departmentIds = explode(',', $hrmSalary->department_ids);

        $userIdMapUserList = $this->userRepository->model()
            ->whereIn('department_id', $departmentIds)
            ->where(function ($query) use ($userId){
                if($userId) {
                    $query->where('id', $userId);
                }
            })->get()->keyBy('id');


        $hrmSalaryDetailList = [];

        foreach ($userIdMapUserList as $userId => $user) {

            $userShiftTypeData = $this->getUserShiftType($userId);

            $userShiftType = $userShiftTypeData && ! empty($userShiftTypeData['shift_type'])
                ? $userShiftTypeData['shift_type']
                : self::WORKING_SHIFT_TYPE_FULL_TIME;

            $salaryAttributesObject = new HrmSalaryDetailStatisticObject();

            # Set thông tin ca làm việc.
            switch ($userShiftType) {
                case self::WORKING_SHIFT_TYPE_PART_TIME:
                    $this->setSalaryAttributesPartTimeWorkingShift($user, $hrmSalary->month, $hrmSalary->year, $salaryAttributesObject);
                    break;
                case self::WORKING_SHIFT_TYPE_FULL_TIME:
                    $this->setSalaryAttributesFullTimeWorkingShift($user, $hrmSalary->month, $hrmSalary->year, $salaryAttributesObject);
                    break;
                default:
                    break;
            }

            # Set thông tin các chỉ số còn lại.
            $this->setHrmSalaryDetailStatisticProperties($user,  $hrmSalary->month, $hrmSalary->year, $salaryAttributesObject);

            $salaryAttributesData = [];

            # Map tên thuộc tính.
            foreach ($salaryAttributesObject->getData() as $key => $value) {
                $salaryAttributesData['statistic_'.$key] = $value;
            }

            # Bảng lương mới lưu theo user id.
//            $hrmSalaryDetailList = HrmSalaryDetail::install(array_merge([
//                'contact_id' => $user->id,
//                'shift_type' => $userShiftType,
//                'salary_month' => $hrmSalary->month,
//                'salary_year' => $hrmSalary->year,
//                'department_id' => $user->department_id,
//            ], $salaryAttributesData));

              $hrmSalaryDetailList[] = array_merge([
                'contact_id' => $user->id,
                'shift_type' => $userShiftType,
                'salary_month' => $hrmSalary->month,
                'salary_year' => $hrmSalary->year,
                'department_id' => $user->department_id,
            ], $salaryAttributesData);
        }

        return $hrmSalaryDetailList;
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
            $this->timekeepingLogsStatisticService->getListInMonth([
                'month' => $salaryMonth,
                'year' => $salaryYear,
                'shift_id' => $workingShift['id']
            ], $user->id, $shiftStatistics);
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
              'working_shift_settings.shift_type' => self::WORKING_SHIFT_TYPE_FULL_TIME
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

    private function setSalaryAttributesPartTimeWorkingShift( $user,  $month,  $year, HrmSalaryDetailStatisticObject $salaryAttributesObject)
    {
        [$firstDateOfMonth, $lastDateOfMonth] = $this->getFirstAndLastDateOfMonth($month, $year);
//dd($firstDateOfMonth, $lastDateOfMonth);
        $workingShifts = $this->getValidWorkingShiftsByUser($user->id, self::WORKING_SHIFT_TYPE_PART_TIME);

        $salaryAttributesObject->number_of_standard_working_days = 0;
        $salaryAttributesObject->number_of_official_working_days = 0;
        $salaryAttributesObject->checkin_late = 0;

        $numberOfStandardWorkingDays = 0;
        $numberOfOfficialWorkingDays = 0;
        $checkinLate = 0;
        $checkoutEarly = 0;

        foreach ($workingShifts as $workingShift) {
            # Công chuẩn trong tháng
            $standardWorkInMonth = $this->countTheoryWorkingNumber($workingShift, $firstDateOfMonth, $lastDateOfMonth);

            # Thống kê ca làm việc
            $shiftStatistics = new TimeKeepingStatisticObject();
            $this->timekeepingLogsStatisticService->getListInMonth(new ParamHandler([
                'month' => $month,
                'year' => $year,
                'shift_id' => $workingShift['shift_id']
            ]), $user->id, $shiftStatistics);

            #Công chuẩn
            $numberOfStandardWorkingDays += $standardWorkInMonth;

            #Số ngày làm chính thức
            $numberOfOfficialWorkingDays += round($shiftStatistics->total_work_number, 2);

            #Số buổi đi muộn
            $checkinLate += $shiftStatistics->total_checkin_late;

            $checkoutEarly += $shiftStatistics->total_checkout_early;
        }

        $salaryAttributesObject->set('number_of_standard_working_days', $numberOfStandardWorkingDays);
        $salaryAttributesObject->set('number_of_official_working_days', $numberOfOfficialWorkingDays);
        $salaryAttributesObject->set('checkin_late', $checkinLate);
        $salaryAttributesObject->set('checkout_early', $checkoutEarly);
    }

    private function getFirstAndLastDateOfMonth( $month,  $year): array
    {
        return [
            date('Y-m-d 00:00:00', strtotime(date("$year-$month-01"))),
            date('Y-m-d 23:59:59', strtotime(Carbon::create($year, $month)->lastOfMonth()->toDateString())),
        ];
    }

    private function getUserShiftType( $userId)
    {
        return (array) DB::table('working_shift_users')
            ->leftJoin('working_shift_settings', 'working_shift_settings.id', '=',  'working_shift_users.working_shift_setting_id')
            ->where(
               'working_shift_users.user_id', $userId
            )
            ->first();
    }

    public function index()
    {
        $breadcrumbs = [
            [
                'link' => null,
                'text' => __('Quản lý tiền lương')
            ],
        ];
//        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_DEPARTMENT);
        $data = [
            'pageName' =>  trans('Quản lý tiền lương'),
            'breadcrumbs' => $breadcrumbs,
            'btnAdd' => true,
        ];
        return view('admin.salaries.index')->with($data);
    }

    public function salaryContacts()
    {
        $breadcrumbs = [
            [
                'link' => null,
                'text' => __('Danh sách bảng lương nhân viên')
            ],
        ];
//        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_DEPARTMENT);
        $data = [
            'pageName' =>  trans('Chi tiết bảng lương các nhân viên theo phòng ban'),
            'breadcrumbs' => $breadcrumbs,
            'btnAdd' => true,
        ];
        return view('admin.salaries.salary-contacts.index')->with($data);
    }

    public function getSalaryContacts(Request $request)
    {
        $salaryId = request('salary_id');;

        $stt = 1;

        $results = DB::table('salary_contacts')
            ->join('contacts', 'salary_contacts.contact_id', '=', 'contacts.id')
            ->join('departments', 'salary_contacts.department_id', '=', 'departments.id')
            ->where('salary_contacts.salary_id', $salaryId)
            ->select(
                'salary_contacts.*',
                'contacts.contact_code',
                'contacts.full_name',
                'departments.name as department_name'
            )
            ->get()->map(function ($entry) use ( &$stt) {

                $entry->stt = $stt;
                $entry->attributes = $entry->attributes ? json_decode($entry->attributes) : [];
                $stt ++;
                return $entry;

            });


         return $this->successResponse($results->toArray(), 200, false);
    }

    public function getAllSalaries(Request $request)
    {
        $monthYear = explode('-', $request->month);

        $month = $monthYear[1] ?? null;
        $year = $monthYear[0] ?? null;

        $salaries = $this->salariesRepository->model()->where(function ($query) use (
            $month,
            $year
        ) {
            if ($month) {
                $query->where('month', $month);
            }

            if ($year) {
                $query->where('year', $year);
            }
        })->orderByDesc('id')->get();
        $this->setTransformer(new SalaryTransformer());

        return $this->responseCollection(
            $salaries,
            200
        );
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(salaryStoreRequest $request)
    {
        $data = $request->all();
        $departmentIds = array_column($data['department_ids'], 'id');
        $departmentIds = implode(',', $departmentIds);

        $departmentNames = array_column($data['department_ids'], 'name');
        $departmentNames =implode(',', $departmentNames);;

        $attributes = [
          'name' =>   $data['name'],
          'month' =>   $data['month'],
          'year' =>   $data['year'],
          'department_ids' =>  $departmentIds,
          'department_names' =>  $departmentNames,
        ];

        try {
            $salary = $this->salariesRepository->create($attributes);

            $salaryAttributes = $this->prepareHrmSalaryContactsToCreate($salary, null);
            foreach ($salaryAttributes as $salaryAttributesData) {
                DB::table('salary_contacts')->insert([
                    'salary_id' => $salary->id,
                    'contact_id' => $salaryAttributesData['contact_id'] ?? null,
                    'department_id' => $salaryAttributesData['department_id'] ?? null,
                    'salary_month' => $salaryAttributesData['salary_month'] ?? null,
                    'salary_year' => $salaryAttributesData['salary_year'] ?? null,
                    'attributes' => json_encode($salaryAttributesData),
                ]);
            }

            return $this->successResponse(['salaries' => $salary, 'message' => trans('Thêm bảng lương thành công!')], 200);
        }catch (\Exception $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(salaryUpdateRequest $request, $id)
    {
        $entry = $this->salariesRepository->find($id);

        $data = $request->all();
        $departmentIds = array_column($data['department_ids'], 'id');
        $departmentIds = implode(',', $departmentIds);

        $departmentNames = array_column($data['department_ids'], 'name');
        $departmentNames =implode(',', $departmentNames);;

        $attributes = [
            'name' =>   $data['name'],
            'month' =>   $data['month'],
            'year' =>   $data['year'],
            'department_ids' =>  $departmentIds,
            'department_names' =>  $departmentNames,
        ];

        if(!$entry) {
            return $this->errorsResponse(['id' => trans('Không tồn tại bảng lương !')], 422);
        }

        try {
            $salary = $entry->update($attributes);

            DB::table('salary_contacts')->where('salary_id', $salary->id)->delete();

            $salaryAttributes = $this->prepareHrmSalaryContactsToCreate($salary, null);

            foreach ($salaryAttributes as $salaryAttributesData) {
                DB::table('salary_contacts')->insert([
                    'salary_id' => $salary->id,
                    'contact_id' => $salaryAttributesData['contact_id'] ?? null,
                    'department_id' => $salaryAttributesData['department_id'] ?? null,
                    'salary_month' => $salaryAttributesData['salary_month'] ?? null,
                    'salary_year' => $salaryAttributesData['salary_year'] ?? null,
                    'attributes' => json_encode($salaryAttributesData),
                ]);
            }

            return $this->successResponse(['salary' => $salary, 'message' => trans('Cập nhật bảng lương thành công!')], 200);
        }catch (\Exception $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $entry = $this->salariesRepository->find($id);
        if(!$entry){
            return $this->errorsResponse(['id' => trans('Không tồn tại bảng lương !')], 422);
        }
        try {
            DB::table('salary_contacts')->where('salary_id', $entry->id)->delete();
            $entry->delete();
            return $this->successResponse(['department' => $entry,'message' => trans('Xóa bảng lương thành công!')], 200);
        } catch (\Exception $e) {
            return $this->errorResponse(['id' => $e->getMessage()]);
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

    private function setTotalWorkingDay(HrmSalaryDetailStatisticObject $salaryAttributesObject)
    {
        $totalWorkingDay = $salaryAttributesObject->number_of_official_working_days
            + $salaryAttributesObject->number_of_probationary_working_days
            + $salaryAttributesObject->number_of_probationary_working_days_on_weekly
            + $salaryAttributesObject->number_of_official_working_days_on_weekly
            + $salaryAttributesObject->number_of_probationary_working_days_on_holidays
            + $salaryAttributesObject->number_of_official_working_days_on_holidays;

        $salaryAttributesObject->total_working_days =  round($totalWorkingDay, 2);
    }

    private function setSalaryByWorkingDay(HrmSalaryDetailStatisticObject $salaryAttributesObject)
    {
        $salaryByWorkingDay = 0;

        if ($salaryAttributesObject->number_of_standard_working_days > 0) {
            $salaryByWorkingDay = (
                    $salaryAttributesObject->number_of_probationary_working_days * $salaryAttributesObject->probationary_salary
                    + $salaryAttributesObject->number_of_official_working_days * $salaryAttributesObject->official_salary
                    + $salaryAttributesObject->number_of_probationary_working_days_on_weekly * $salaryAttributesObject->probationary_salary * 2
                    + $salaryAttributesObject->number_of_official_working_days_on_weekly * $salaryAttributesObject->official_salary * 2
                    + $salaryAttributesObject->number_of_probationary_working_days_on_holidays * $salaryAttributesObject->probationary_salary * 2
                    + $salaryAttributesObject->number_of_official_working_days_on_holidays * $salaryAttributesObject->official_salary * 2
                ) / $salaryAttributesObject->number_of_standard_working_days;
        }

        $salaryAttributesObject->salary_by_working_day = $salaryByWorkingDay;

    }

    private function setOtherAllowance(HrmSalaryDetailStatisticObject $salaryAttributesObject)
    {
        $otherAllowanceList = DB::table('allowances')->get();

        $otherAllowances = [];
        $defaultAllowances = [];

        $oldOtherAllowances = $salaryAttributesObject->other_allowances;

        foreach ($otherAllowanceList as $allowance) {
            if ($salaryAttributesObject->other_allowance_ids && in_array($allowance->id, $salaryAttributesObject->other_allowance_ids)) {

                $otherAllowance = [
                    'allowance_id' => $allowance->id,
                    'allowance_name' => $allowance->allowance_name,
                    'can_edit' => $allowance->allowance_type == Allowance::MANUAL_TYPE ? 1 : 0,
                    'allowance_type' => $allowance->allowance_type,
                    'default'       => $allowance->default
                ];

                switch ($allowance->allowance_type) {
                    case Allowance::FIXED_TYPE:
                        $otherAllowance['allowance_amount'] = $allowance->allowance_amount;
                        break;
                    case Allowance::WORKED_DAYS_TYPE:
                        if ($salaryAttributesObject->number_of_standard_working_days > 0) {
                            $percent = ($salaryAttributesObject->number_of_probationary_working_days + $salaryAttributesObject->number_of_official_working_days)
                                / $salaryAttributesObject->number_of_standard_working_days;

                            $percent = $percent <= 100 ? $percent : 100;
                            $otherAllowance['allowance_amount'] = $allowance->allowance_amount * $percent;
                        } else {
                            $otherAllowance['allowance_amount'] = 0;
                        }
                        break;
                    case Allowance::MANUAL_TYPE:
                        $allowanceId = $allowance->id;

                        $filter = array_values(array_filter(
                            $oldOtherAllowances,
                            function ($oldAllowance) use ($allowanceId) {
                                return isset($oldAllowance['allowance_id']) && $oldAllowance['allowance_id'] == $allowanceId;
                            }
                        ));

                        if (empty($filter)) {
                            $otherAllowance['allowance_amount'] = 0;
                        } else {
                            $otherAllowance['allowance_amount'] = $filter[0]['allowance_amount'];
                        }

                        break;
                    default:
                        $otherAllowance['allowance_amount'] = 0;
                }

                if($allowance->default) {
                    $defaultAllowances[] = $allowance->default;
                    continue;
                }

                $otherAllowances[] = $otherAllowance;
            }
        }

        $salaryAttributesObject->other_allowances = $otherAllowances;
        $salaryAttributesObject->default_allowances = $defaultAllowances;
    }

    private function setHrmSalaryDetailStatisticProperties($user,  $month,  $year, HrmSalaryDetailStatisticObject $salaryAttributesObject)
    {
        //Set thông tin từ hợp đồng
        $this->setSalaryAttributesFromContract($user, $month, $year, $salaryAttributesObject);

        //Tính tổng ngày công nhân viên
        $this->setTotalWorkingDay($salaryAttributesObject);

        //Tính lương theo ngày công
        $this->setSalaryByWorkingDay($salaryAttributesObject);

        //Tính các phụ cấp khác
        $this->setOtherAllowance($salaryAttributesObject);

        //Tính phụ cấp ăn trưa
        $this->setLunchAllowance($salaryAttributesObject);

        //Tính phụ cấp xăng xe
        $this->setGasAllowance($salaryAttributesObject);

        //Tính phụ cấp chuyên cần
        $this->setAttendanceAllowance($salaryAttributesObject);

        //Tính phụ cấp nuôi con nhỏ và số người phụ thuộc
//        $this->setChildCareAllowanceAndNumberOfDependentPerson($user->identity(), $month, $year, $salaryAttributesObject);

        //Tính tổng phụ cấp
        $this->setTotalAllowance($salaryAttributesObject);

        //Tính Lương doanh số
//        $this->setSalesSalary($user->identity(), $month, $year, $salaryAttributesObject);

        //Tính % kpi
//        $this->setMonthKpi($user->identity(), $month, $year, $salaryAttributesObject);

        //Tính lương P3 tháng, quý, 6 tháng
//        $this->setP3Salary($salaryAttributesObject, $user->userDepartment(), $month, $year);

        //Tính P3 tích lũy
//        $this->setCumulativeQuarterlyP3($user->identity(), $month, $year, $salaryAttributesObject);

        //Tính tổng thu nhập trước thuế
        $this->setTotalIncomeBeforeTax($salaryAttributesObject);

        //Tính Bảo hiểm doanh nghiệp trả
        $this->setEnterpriseInsurancePaid($salaryAttributesObject, $month, $year);

        //Tính Bảo hiểm người lao động trả
        $this->setWorkerInsurancePaid($salaryAttributesObject);

        //Tính tổng giảm trừ gia cảnh
//        $this->setTotalFamilyAllowances($salaryAttributesObject);

        //Tính tổng các khoản được giảm trừ
        $this->setTotalDeductions($salaryAttributesObject);

        //Thu nhập tính thuế tạm tính
        $this->setProvisionalTaxableIncome($salaryAttributesObject);

        //Tính thuế thu nhập cá nhân
        $this->setPersonalIncomeTax($salaryAttributesObject);

        //Tính thu nhập sau thuế
        $this->setIncomeAfterPersonalIncomeTax($salaryAttributesObject);

        //Tính P3 cuối mỗi tháng, quý
//        $this->setCumulativeP3BonusPaidAtTheEndOfQuarterMonth($user->identity(), $month, $year, $salaryAttributesObject);

        //Tính các khoản thưởng
//        $this->setBonus($user->identity(), $month, $year, $salaryAttributesObject);

        //Tính tiền quỹ nội bộ
        $this->setInternalFund($salaryAttributesObject);

        //Tính tổng thu nhập tháng
        $this->setTotalIncome($salaryAttributesObject);

        // Tính số tiền vi phạm nội quy chấm công
        $this->setTotalBreakingRules($salaryAttributesObject);

        //Tính tổng tiền thanh toán tháng
        $this->setTotalPayment($salaryAttributesObject);

        //Lấy số tiền thanh toán của tháng trước
//        $this->setLastMonthIncome($user->id, $month, $year, $salaryAttributesObject);
    }

    private function setTotalPayment(HrmSalaryDetailStatisticObject $salaryAttributesObject)
    {
        $totalPayment = $salaryAttributesObject->total_income
            - $salaryAttributesObject->fines_for_breaking_the_rules
            - $salaryAttributesObject->deduction
            - $salaryAttributesObject->penalty_for_late_withdrawal_of_the_contract;

        $salaryAttributesObject->total_payment = $totalPayment;
    }

    private function setTotalBreakingRules(HrmSalaryDetailStatisticObject $salaryAttributesObject)
    {
        $salaryAttributesObject->fines_for_breaking_the_rules = 0;

        $totalBreakingRules = ($salaryAttributesObject->checkin_late + $salaryAttributesObject->checkout_early - 3) * 20000;

        if($totalBreakingRules > 0) {
            $salaryAttributesObject->fines_for_breaking_the_rules = $totalBreakingRules;
        }

    }

    private function setTotalIncome(HrmSalaryDetailStatisticObject $salaryAttributesObject)
    {
        $totalIncome = $salaryAttributesObject->income_after_personal_income_tax
            + $salaryAttributesObject->refund
            + $salaryAttributesObject->bonus
            + $salaryAttributesObject->paying_the_contract_fines_withdrawn_beginning_year
            - $salaryAttributesObject->internal_fund;

        $salaryAttributesObject->total_income = $totalIncome;
    }

    private function setInternalFund(HrmSalaryDetailStatisticObject $salaryAttributesObject)
    {
        $salaryAttributesObject->internal_fund = 0;

        if ($salaryAttributesObject->number_of_standard_working_days > 0) {

            $internalFundType = DB::table('init_values')
                ->where('init_name', InitValue::INIT_NAME_INTERNAL_FUND_TYPE)
                ->first();

            $internalFund = DB::table('init_values')
                ->where('init_name', InitValue::INIT_NAME_INTERNAL_FUND)
                ->first();


            $internalFundAmount = $internalFundType->init_value == "percent" ? $internalFund->init_value / 100 *
                ($salaryAttributesObject->number_of_probationary_working_days * $salaryAttributesObject->probationary_salary
                    + $salaryAttributesObject->number_of_official_working_days * $salaryAttributesObject->official_salary
                ) / $salaryAttributesObject->number_of_standard_working_days : $internalFund->init_value;

            $salaryAttributesObject->internal_fund = $internalFundAmount;
        }
    }

    private function setIncomeAfterPersonalIncomeTax(HrmSalaryDetailStatisticObject $salaryAttributesObject)
    {
        $incomeAfterPersonalIncomeTax = $salaryAttributesObject->total_income_before_tax
            - $salaryAttributesObject->worker_insurance_paid
            - $salaryAttributesObject->personal_income_tax;

        $salaryAttributesObject->income_after_personal_income_tax = $incomeAfterPersonalIncomeTax;
    }

    private function setPersonalIncomeTax(HrmSalaryDetailStatisticObject $salaryAttributesObject)
    {

        $tax = DB::table('settings')
            ->where('type', 'TAX_CALCUL')
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(`value`, '$.tax_income_from')) <= ?",  $salaryAttributesObject->provisional_taxable_income)
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(`value`, '$.tax_income_to')) >= ?",  $salaryAttributesObject->provisional_taxable_income)
            ->orderByDesc('created_at')
            ->first();


        $personalTaxMoney = 0;

        if ($tax) {
            $valueJson = $tax->value ? json_decode($tax->value): null;
            $personalTaxMoney = $valueJson->tax_rate / 100 * $salaryAttributesObject->provisional_taxable_income - $valueJson->tax_reduction;
        }

        $salaryAttributesObject->personal_income_tax = $personalTaxMoney;
    }


    private function setTotalDeductions(HrmSalaryDetailStatisticObject $salaryAttributesObject)
    {
        $totalDeductions = $salaryAttributesObject->worker_insurance_paid;

        $salaryAttributesObject->total_deductions = $totalDeductions;
    }

    private function setProvisionalTaxableIncome(HrmSalaryDetailStatisticObject $salaryAttributesObject)
    {
        $provisionalTaxableIncome = $salaryAttributesObject->total_income_before_tax - $salaryAttributesObject->total_deductions;

        $provisionalTaxableIncome = $provisionalTaxableIncome > 0 ? $provisionalTaxableIncome : 0;

        $salaryAttributesObject->provisional_taxable_income = $provisionalTaxableIncome;
    }

    private function setEnterpriseInsurancePaid(HrmSalaryDetailStatisticObject $salaryAttributesObject,  $month,  $year)
    {
        [$firstDateOfMonth, $lastDateOfMonth] = $this->getFirstAndLastDateOfMonth($month, $year);

        $enterpriseInsurancePaid = DB::table('settings')
            ->where('type', 'ENTERPRISE_INSURANCE_PAID')
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(`value`, '$.start_date')) <= ?", [$firstDateOfMonth . ' 00:00:00'])
            ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(`value`, '$.end_date')) >= ?", [$lastDateOfMonth . ' 23:59:59'])
            ->first();

        $pensionInsurance = 0;                              # % DN đóng chế độ Hưu trí
        $sicknessAndMaternityInsurance = 0;                 # % DN đóng chế độ Ốm đau - Thai sản
        $laborAccidentAndOccupationalDiseaseInsurance = 0;  # % DN đóng Chế độ tai nạn lao động, bệnh nghề nghiệp
        $unemploymentInsurance = 0;                         # % DN đóng Chế độ thất nghiệp
        $healthInsurance = 0;                               # % DN đóng Bảo hiểm Y tế
        $valueJson = $enterpriseInsurancePaid->value ? json_decode($enterpriseInsurancePaid->value): null;
        if ($enterpriseInsurancePaid && $valueJson) {

            $pensionInsurance = $valueJson->pension_insurance ? $valueJson->pension_insurance : 0;

            $sicknessAndMaternityInsurance = $valueJson->sickness_and_maternity_insurance ? $valueJson->sickness_and_maternity_insurance : 0;

            $laborAccidentAndOccupationalDiseaseInsurance = $valueJson->labor_accident_and_occupational_disease_insurance
                ? $valueJson->labor_accident_and_occupational_disease_insurance : 0;

            $unemploymentInsurance = $valueJson->unemployment_insurance ? $valueJson->unemployment_insurance : 0;

            $healthInsurance = $valueJson->health_insurance ? $valueJson->health_insurance : 0;

        }

        $insurancePercent = $pensionInsurance + $sicknessAndMaternityInsurance
            + $laborAccidentAndOccupationalDiseaseInsurance + $unemploymentInsurance + $healthInsurance;

        $salaryAttributesObject->enterprise_insurance_paid =  $salaryAttributesObject->basic_salary * $insurancePercent/ 100;
    }

    private function setWorkerInsurancePaid(HrmSalaryDetailStatisticObject $salaryAttributesObject): void
    {

        $workerInsurance = DB::table('settings')
            ->where('type', 'WORKER_INSURANCE_PAID')
            ->first();

        $pensionInsurance = 0;
        $sicknessAndMaternityInsurance = 0;
        $laborAccidentAndOccupationalDiseaseInsurance = 0;
        $unemploymentInsurance = 0;
        $healthInsurance = 0;
        $valueJson = $workerInsurance->value ? json_decode($workerInsurance->value): null;
        if ($workerInsurance) {
            $pensionInsurance = $valueJson->pension_insurance ? $valueJson->pension_insurance : 0;

            $sicknessAndMaternityInsurance = $valueJson->sickness_and_maternity_insurance ? $valueJson->sickness_and_maternity_insurance : 0;

            $laborAccidentAndOccupationalDiseaseInsurance = $valueJson->labor_accident_and_occupational_disease_insurance
                ? $valueJson->labor_accident_and_occupational_disease_insurance : 0;

            $unemploymentInsurance = $valueJson->unemployment_insurance ? $valueJson->unemployment_insurance : 0;

            $healthInsurance = $valueJson->health_insurance ? $valueJson->health_insurance : 0;
        }

        $insurancePercent = $pensionInsurance + $sicknessAndMaternityInsurance + $laborAccidentAndOccupationalDiseaseInsurance
            + $unemploymentInsurance + $healthInsurance;

        $salaryAttributesObject->worker_insurance_paid = $salaryAttributesObject->basic_salary * $insurancePercent/ 100;
    }

    private function setTotalIncomeBeforeTax(HrmSalaryDetailStatisticObject $salaryAttributesObject)
    {

        $totalIncomeBeforeTax =  $salaryAttributesObject->salary_by_working_day
            + $salaryAttributesObject->total_allowance;
//            + $salaryAttributesObject->sales_salary

        $salaryAttributesObject->total_income_before_tax = $totalIncomeBeforeTax;
    }

    private function setTotalAllowance(HrmSalaryDetailStatisticObject $salaryAttributesObject)
    {
        $totalAllowance = $salaryAttributesObject->lunch_allowance
            + $salaryAttributesObject->attendance_allowance
            + $salaryAttributesObject->child_care_allowance
            + $salaryAttributesObject->gas;

        $salaryAttributesObject->total_allowance = $totalAllowance;

        foreach ($salaryAttributesObject->other_allowances as $otherAllowance) {
            $totalAllowance = $salaryAttributesObject->total_allowance;
            $totalAllowance += $otherAllowance['allowance_amount'];

            $salaryAttributesObject->totalAllowance = $totalAllowance;
        }
    }


    private function setGasAllowance(HrmSalaryDetailStatisticObject $salaryAttributesObject)
    {
        $allowanceDefaults = $salaryAttributesObject->default_allowances;
        $gasAllowance = 0;

        if (
            $salaryAttributesObject->number_of_standard_working_days > 0
            && in_array(Allowance::ALLOWANCE_GAS_DEFAULT, $allowanceDefaults)
        ) {
            $otherAllowance =  $this->getOneOtherAllowance(Allowance::ALLOWANCE_GAS_DEFAULT);

            $percent = ($salaryAttributesObject->number_of_probationary_working_days + $salaryAttributesObject->number_of_official_working_days)
                / $salaryAttributesObject->number_of_standard_working_days;

            $percent = $percent <= 100 ? $percent : 100;
            $gasAllowance = $otherAllowance? $otherAllowance->allowance_amount * $percent : 0;

        }

        $salaryAttributesObject->gas = $gasAllowance;
    }

    private function setLunchAllowance(HrmSalaryDetailStatisticObject $salaryAttributesObject)
    {
        $allowanceDefaults = $salaryAttributesObject->default_allowances;
        $lunchAllowance = 0;

        if (
            $salaryAttributesObject->number_of_standard_working_days > 0
            && in_array(Allowance::ALLOWANCE_HAVE_LAUNCH_DEFAULT, $allowanceDefaults)
        ) {
            $otherAllowance =  $this->getOneOtherAllowance(Allowance::ALLOWANCE_HAVE_LAUNCH_DEFAULT);

            $percent = ($salaryAttributesObject->number_of_probationary_working_days + $salaryAttributesObject->number_of_official_working_days)
                / $salaryAttributesObject->number_of_standard_working_days;

            $percent = $percent <= 100 ? $percent : 100;
            $lunchAllowance = $otherAllowance? $otherAllowance->allowance_amount * $percent : 0;

        }

        $salaryAttributesObject->lunch_allowance = $lunchAllowance;
    }

    private function getOneOtherAllowance( $defaultAllowance)
    {
        return DB::table('allowances')->where('default', $defaultAllowance)

            ->where('valid', 1)->first();
    }

    private function setAttendanceAllowance(HrmSalaryDetailStatisticObject $salaryAttributesObject)
    {
        $allowanceDefaults = $salaryAttributesObject->default_allowances;

        if(
            $salaryAttributesObject->number_of_standard_working_days > 0
            && in_array(Allowance::ALLOWANCE_ATTENDANCE_DEFAULT, $allowanceDefaults)
        ) {

            $attendanceAllowance = $this->getOneOtherAllowance(Allowance::ALLOWANCE_ATTENDANCE_DEFAULT);

            $allowed_number_days = $attendanceAllowance->allowed_number_days ? $attendanceAllowance->allowed_number_days : 0;

            $diff = $salaryAttributesObject->number_of_standard_working_days - $salaryAttributesObject->total_working_days;

            if ($diff <= $allowed_number_days) {
                $salaryAttributesObject->attendance_allowance = $attendanceAllowance->allowance_amount;
                return;
            }
        }

        $salaryAttributesObject->attendance_allowance = 0;
    }

    private function setSalaryAttributesFromContract( $user,  $month,  $year, HrmSalaryDetailStatisticObject $salaryAttributesObject)
    {
        [$firstDateOfMonth, $lastDateOfMonth] = $this->getFirstAndLastDateOfMonth($month, $year);

        $contact = DB::table('contacts')
            ->where('user_id', $user->id)
            ->first();

        # Hợp đồng nhân sự
        $salaryContract = DB::table('contracts')
            ->where('contact_id', $contact->id)
            ->where('effective_date', '<=', $firstDateOfMonth)
            ->where('expiration_date', '>=', $lastDateOfMonth)
            ->first();

        if ($salaryContract) {
            $payRollDetailInfo = $this->getPayrollDetail($salaryContract, $firstDateOfMonth, $lastDateOfMonth);

            #Lương chính thức = P1 + P2
            $officialSalary = $payRollDetailInfo['position_based_pay'] + $payRollDetailInfo['person_based_pay'];

            #Tổng P3 theo hợp đồng trước đó
            $salaryAttributesObject->is_total_p3_under_contract_changed = $salaryAttributesObject->total_p3_under_contract != $payRollDetailInfo['performance_based_pay'];

            #Tổng P3 theo hợp đồng
            $salaryAttributesObject->total_p3_under_contract = $payRollDetailInfo['performance_based_pay'];

            #Lương thử việc = 85% lương chính thức
            $salaryAttributesObject->probationary_salary = $officialSalary * 0.85;
            $salaryAttributesObject->official_salary = $officialSalary;


            #Lương cơ bản theo hợp đồng
//            $basicSalary = $this->getBasicSalary($salaryContract->wegeDetailId());

            $salaryAttributesObject->basic_salary = $salaryContract->basic_salary;

            //Danh sách id phụ cấp khác
            $salaryAttributesObject->other_allowance_ids = $salaryContract->allowances ? explode(',', $salaryContract->allowances): [];
        }
    }

    private function getPayrollDetail( $salaryContract,  $firstDateOfMonth,  $lastDateOfMonth)
    {
        $defaultPayRangeDetailInfo = [
            'position_based_pay' => 0,
            'person_based_pay' => 0,
            'performance_based_pay' => 0,
            'lunch_allowance' => 0
        ];

        $payRoll = DB::table('pay_rolls')->where('id', $salaryContract->pay_roll_id)
            ->where('start_date','<=', $firstDateOfMonth.' 00:00:00')
            ->where('end_date','>=', $lastDateOfMonth.' 23:59:59')->first();
        ;


        if ($payRoll) {
            $payRangeList = $this->getAllValidHrmPayrollDetails($payRoll->id);

            foreach ($payRangeList as $payRange) {

                if ($payRange['id'] === $salaryContract->pay_range_id) {
                    $defaultPayRangeDetailInfo = [
                        'position_based_pay' => $payRange['position_based_pay'],
                        'person_based_pay' => $payRange['person_based_pay'],
                        'performance_based_pay' => $payRange['performance_based_pay'],
                    ];
                }
            }
        }

        return $defaultPayRangeDetailInfo;
    }

    public function getAllValidHrmPayrollDetails( $hrmPayrollId)
    {
        $hrmPayrollDetailRecords = DB::table('pay_ranges')->where('pay_roll_id', $hrmPayrollId)->get();

        $hrmPayrollDetails = [];

        foreach ($hrmPayrollDetailRecords as $hrmPayrollDetailRecord) {
            $hrmPayrollDetailRecord = (array) $hrmPayrollDetailRecord;

            $installData = [
                'id' => $hrmPayrollDetailRecord['id'],
                'pay_roll_id' => $hrmPayrollDetailRecord['pay_roll_id'],
                'position_based_pay' => $hrmPayrollDetailRecord['position_based_pay'],
                'person_based_pay' => $hrmPayrollDetailRecord['person_based_pay'],
                'performance_based_pay' => $hrmPayrollDetailRecord['performance_based_pay'],
            ];

            $hrmPayrollDetails[] = $installData;
        }

        return $hrmPayrollDetails;
    }
}
