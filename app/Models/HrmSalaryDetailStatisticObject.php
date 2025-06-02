<?php


namespace App\Models;


class HrmSalaryDetailStatisticObject
{
    /**
     * Công chuẩn
     *
     * @var
     */
    public    $number_of_standard_working_days = 0;

    /**
     * Số ngày thử việc
     *
     * @var
     */
    public    $number_of_probationary_working_days = 0;

    /**
     * Lương thử việc
     *
     * @var
     */
    public    $probationary_salary = 0;

    /**
     * Số ngày làm việc chính thức
     *
     * @var
     */
    public    $number_of_official_working_days = 0;

    /**
     * Lương chính thức
     *
     * @var
     */
    public    $official_salary = 0;

    /**
     * Số ngày làm việc thử vào ngày nghỉ
     *
     * @var
     */
    public    $number_of_probationary_working_days_on_holidays = 0;

    /**
     * Số ngày làm việc chính thức vào ngày nghỉ
     *
     * @var
     */
    public    $number_of_official_working_days_on_holidays = 0;

    /**
     * Số ngày làm việc thử vào ngày nghỉ cuối tuần
     *
     * @var
     */
    public    $number_of_probationary_working_days_on_weekly = 0;

    /**
     * Số ngày làm việc chính thức vào ngày nghỉ cuối tuần
     *
     * @var
     */
    public    $number_of_official_working_days_on_weekly = 0;

    /**
     * Hỗ trợ xăng xe
     *
     * @var   |null
     */
    public    $gas = 0;

    /**
     * Tổng số ngày làm việc
     *
     * @var
     */
    public    $total_working_days = 0;

    /**
     * Lương tính theo ngày công
     *
     * @var
     */
    public    $salary_by_working_day = 0;

    /**
     * Phụ cấp ăn trưa
     *
     * @var
     */
    public    $lunch_allowance = 0;

    /**
     * Phụ cấp chuyên cần
     *
     * @var
     */
    public    $attendance_allowance = 0;

    /**
     * Phụ cấp nuôi con nhỏ
     *
     * @var
     */
    public    $child_care_allowance = 0;

    /**
     * Tổng phụ cấp
     *
     * @var
     */
    public    $total_allowance = 0;

    /**
     * Doanh số đã thanh toán
     *
     * @var
     */
    public    $sales_paid_to_employee = 0;

    /**
     * Lương doanh số
     *
     * @var
     */
    public    $sales_salary = 0;

    /**
     * Phiếu kpi
     *
     * @var
     */
    public    $kpi_sheet_id = 0;

    /**
     * Kpi tháng
     *
     * @var
     */
    public    $month_kpi = 0;

    /**
     * Tổng P3 theo hợp đồng
     *
     * @var
     */
    public    $total_p3_under_contract = 0;

    /**
     * Có thay đổi tổng tiền dưới hợp đồng trước
     * @var
     */
    public     $is_total_p3_under_contract_changed = false;

    /**
     * Sửa phụ cấp khác
     * @var
     */
    private    $edit_other_allowance;

    /**
     * Có thay đổi %kpi tháng
     * @var
     */
    public     $is_month_kpi_changed = false;

    /**
     * P3 tháng
     *
     * @var
     */
    public      $p3_month = 0;

    /**
     * p3 quý %
     *
     * @var
     */
    public      $quarterly_p3 = 0;

    /**
     *
     * @var
     */
    public      $quarterly_p3_amount = 0;

    /**
     * p3 6 tháng %
     *
     * @var
     */
    public      $p3_6_months = 0;

    /**
     * p3 6 tháng thành tiền
     *
     * @var
     */
    public      $p3_6_months_amount = 0;

    /**
     * p3 tháng thực tế
     *
     * @var
     */
    public      $real_p3_month = 0;

    /**
     * p3 quý tích lũy
     *
     * @var
     */
    public      $cumulative_quarterly_p3 = 0;

    /**
     * Tổng thu nhập trước thuế
     *
     * @var
     */
    public      $total_income_before_tax = 0;

    /**
     * Mức lương cơ bản
     *
     * @var
     */
    public    $basic_salary = 0;

    /**
     * Bảo hiểm doanh nghiệp trả
     *
     * @var
     */
    public      $enterprise_insurance_paid = 0;

    /**
     * Bảo hiểm người lao động trả
     *
     * @var
     */
    public      $worker_insurance_paid = 0;

    /**
     * Giảm trừ gia cảnh bản thân
     *
     * @var
     */
    public      $personal_family_allowances = 0;

    /**
     * Số lượng người phụ thuộc
     *
     * @var
     */
    public      $number_of_dependent_person = 0;

    /**
     * Giảm trừ người phụ thuộc
     *
     * @var
     */
    public      $dependent_person_deduction = 0;

    /**
     * Tổng giảm trừ gia cảnh
     *
     * @var
     */
    public      $total_family_allowances = 0;

    /**
     * Tổng các khoản được giảm trừ
     *
     * @var
     */
    public      $total_deductions = 0;

    /**
     * Thu nhập chịu thuế tạm tính
     *
     * @var
     */
    public      $provisional_taxable_income = 0;

    /**
     * Thuế thu nhập cá nhân
     *
     * @var
     */
    public      $personal_income_tax = 0;

    /**
     * Thu nhập sau thuế TNCN
     *
     * @var
     */
    public      $income_after_personal_income_tax = 0;

    /**
     * Thưởng P3 tích lũy trả cuối quý, tháng
     *
     * @var
     */
    public      $cumulative_P3_bonus_paid_at_the_end_of_quarter_month = 0;

    /**
     * Hoàn tiền
     *
     * @var
     */
    public      $refund = 0;

    /**
     * Thưởng
     *
     * @var
     */
    public      $bonus = 0;

    /**
     * TT tiền phạt HĐ đã thu hồi về từ đầu năm
     *
     * @var
     */
    public      $paying_the_contract_fines_withdrawn_beginning_year = 0;

    /**
     * Quỹ nội bộ
     *
     * @var
     */
    public      $internal_fund = 0;

    /**
     * Tổng thu nhập
     *
     * @var
     */
    public      $total_income = 0;

    /**
     * Phạt vi phạm nội quy
     *
     * @var
     */
    public      $fines_for_breaking_the_rules = 0;

    /**
     * Khoản trừ
     *
     * @var
     */
    public      $deduction = 0;

    /**
     * Phạt chậm thu hồi hợp đồng
     *
     * @var
     */
    public      $penalty_for_late_withdrawal_of_the_contract = 0;

    /**
     * #Tổng thanh toán
     *
     * @var
     */
    public      $total_payment = 0;

    /**
     * Thu nhập tháng trước
     *
     * @var
     */
    public      $last_month_income = 0;

    /**
     * Ghi chú
     *
     * @var
     */
    public       $note = '';

    /**
     * Số tiền phụ cấp ăn trưa tối đa
     *
     * @var
     */
    public      $max_lunch_allowance = 0;

    /**
     * Số buổi đi muộn
     *
     * @var
     */
    public      $checkin_late = 0;

    /**
     * Số buổi về sớm
     *
     * @var
     */
    public      $checkout_early = 0;

    /**
     * Danh sách id phụ cấp khác
     *
     * @var
     */
    public    $other_allowance_ids = [];

    /**
     * Các phụ cấp khác
     *
     * @var
     */
    public    $other_allowances = [];

    /**
     * Các phụ mặc định của hệ thống
     * 1  phụ cấp ăn trưa, 2  xăng xe, 3  nuôi con nhỏ, 4  chuyên cần
     * @var
     */
    public    $default_allowances = [];

    /**
     * Đã gửi lương chưa
     *
     * @var
     */
    public      $is_sent = 0;

    public function __construct(   $data = [])
    {
        $this->populate($data);
    }

    public function populate($data = []):  self
    {
        foreach ($data as $property => $value) {
            $this->{$property} = $value;
        }

        return $this;
    }

    /**
     * @return
     */
    public function numberOfStandardWorkingDays()
    {
        return $this->number_of_standard_working_days;
    }

    /**
     * @return
     */
    public function numberOfProbationaryWorkingDays()
    {
        return $this->number_of_probationary_working_days;
    }

    /**
     * @return
     */
    public function probationarySalary()
    {
        return $this->probationary_salary;
    }

    /**
     * @return
     */
    public function numberOfOfficialWorkingDays()
    {
        return $this->number_of_official_working_days;
    }

    /**
     * @return
     */
    public function officialSalary()
    {
        return $this->official_salary;
    }

    /**
     * @return
     */
    public function numberOfProbationaryWorkingDaysOnHolidays()
    {
        return $this->number_of_probationary_working_days_on_holidays;
    }

    /**
     * @return
     */
    public function numberOfOfficialWorkingDaysOnHolidays()
    {
        return $this->number_of_official_working_days_on_holidays;
    }

    /**
     * @return
     */
    public function numberOfProbationaryWorkingDaysOnWeekly()
    {
        return $this->number_of_probationary_working_days_on_weekly;
    }

    /**
     * @return
     */
    public function numberOfOfficialWorkingDaysOnWeekly()
    {
        return $this->number_of_official_working_days_on_weekly;
    }

    /**
     * @return
     */
    public function gas()
    {
        return $this->gas;
    }

    /**
     * @return
     */
    public function totalWorkingDays()
    {
        return $this->total_working_days;
    }

    /**
     * @return
     */
    public function salaryByWorkingDay()
    {
        return $this->salary_by_working_day;
    }

    /**
     * Phụ cấp ăn trưa
     *
     * @return
     */
    public function lunchAllowance()
    {
        return $this->lunch_allowance;
    }

    /**
     * Phụ cấp chuyên cần
     *
     * @return
     */
    public function attendanceAllowance()
    {
        return $this->attendance_allowance;
    }

    /**
     * Phụ cấp nuôi con nhỏ
     *
     * @return
     */
    public function childCareAllowance()
    {
        return $this->child_care_allowance;
    }

    /**
     * @return
     */
    public function totalAllowance()
    {
        return $this->total_allowance;
    }

    /**
     * @return
     */
    public function salesPaidToEmployee()
    {
        return $this->sales_paid_to_employee;
    }

    /**
     * @return
     */
    public function salesSalary()
    {
        return $this->sales_salary;
    }

    /**
     * @return
     */
    public function kpiSheetId()
    {
        return $this->kpi_sheet_id;
    }

    /**
     * @return
     */
    public function monthKpi()
    {
        return $this->month_kpi;
    }

    /**
     * @return
     */
    public function totalP3UnderContract()
    {
        return $this->total_p3_under_contract;
    }

    /**
     * @return
     */
    public function isTotalP3UnderContractChanged()
    {
        return $this->is_total_p3_under_contract_changed;
    }

    /**
     * @return
     */
    public function editOtherAllowance()
    {
        return $this->edit_other_allowance;
    }

    /**
     * @return
     */
    public function isMonthKpiChanged()
    {
        return $this->is_month_kpi_changed;
    }

    /**
     * @return
     */
    public function p3Month()
    {
        return $this->p3_month;
    }

    /**
     * @return
     */
    public function quarterlyP3()
    {
        return $this->quarterly_p3;
    }

    /**
     * @return
     */
    public function quarterlyP3Amount()
    {
        return $this->quarterly_p3_amount;
    }

    /**
     * @return
     */
    public function p36Months()
    {
        return $this->p3_6_months;
    }

    /**
     * @return
     */
    public function p36MonthsAmount()
    {
        return $this->p3_6_months_amount;
    }

    /**
     * @return
     */
    public function realP3Month()
    {
        return $this->real_p3_month;
    }

    /**
     * @return
     */
    public function cumulativeQuarterlyP3()
    {
        return $this->cumulative_quarterly_p3;
    }

    /**
     * @return
     */
    public function totalIncomeBeforeTax()
    {
        return $this->total_income_before_tax;
    }

    /**
     * @return
     */
    public function basicSalary()
    {
        return $this->basic_salary;
    }

    /**
     * @return
     */
    public function enterpriseInsurancePaid()
    {
        return $this->enterprise_insurance_paid;
    }

    /**
     * @return
     */
    public function workerInsurancePaid()
    {
        return $this->worker_insurance_paid;
    }

    /**
     * @return
     */
    public function personalFamilyAllowances()
    {
        return $this->personal_family_allowances;
    }

    /**
     * @return
     */
    public function numberOfDependentPerson()
    {
        return $this->number_of_dependent_person;
    }

    /**
     * @return
     */
    public function dependentPersonDeduction()
    {
        return $this->dependent_person_deduction;
    }

    /**
     * @return
     */
    public function totalFamilyAllowances()
    {
        return $this->total_family_allowances;
    }

    /**
     * @return
     */
    public function totalDeductions()
    {
        return $this->total_deductions;
    }

    /**
     * @return
     */
    public function provisionalTaxableIncome()
    {
        return $this->provisional_taxable_income;
    }

    /**
     * @return
     */
    public function personalIncomeTax()
    {
        return $this->personal_income_tax;
    }

    /**
     * @return
     */
    public function incomeAfterPersonalIncomeTax()
    {
        return $this->income_after_personal_income_tax;
    }

    /**
     * @return
     */
    public function cumulativeP3BonusPaidAtTheEndOfQuarterMonth()
    {
        return $this->cumulative_P3_bonus_paid_at_the_end_of_quarter_month;
    }

    /**
     * @return
     */
    public function refund()
    {
        return $this->refund;
    }

    /**
     * @return
     */
    public function bonus()
    {
        return $this->bonus;
    }

    /**
     * @return
     */
    public function payingTheContractFinesWithdrawnBeginningYear()
    {
        return $this->paying_the_contract_fines_withdrawn_beginning_year;
    }

    /**
     * @return
     */
    public function internalFund()
    {
        return $this->internal_fund;
    }

    /**
     * @return
     */
    public function totalIncome()
    {
        return $this->total_income;
    }

    /**
     * @return
     */
    public function finesForBreakingTheRules()
    {
        return $this->fines_for_breaking_the_rules;
    }

    /**
     * @return
     */
    public function deduction()
    {
        return $this->deduction;
    }

    /**
     * @return
     */
    public function penaltyForLateWithdrawalOfTheContract()
    {
        return $this->penalty_for_late_withdrawal_of_the_contract;
    }

    /**
     * @return
     */
    public function totalPayment()
    {
        return $this->total_payment;
    }

    /**
     * @return
     */
    public function lastMonthIncome()
    {
        return $this->last_month_income;
    }

    /**
     * @return
     */
    public function note()
    {
        return $this->note;
    }

    /**
     * @return
     */
    public function maxLunchAllowance()
    {
        return $this->max_lunch_allowance;
    }

    /**
     * @return
     */
    public function checkinLate()
    {
        return $this->checkin_late;
    }

    /**
     * @return
     */
    public function checkoutEarly()
    {
        return $this->checkout_early;
    }

    /**
     * @return
     */
    public function otherAllowanceIds()
    {
        return $this->other_allowance_ids;
    }

    /**
     * @return
     */
    public function otherAllowances()
    {
        return $this->other_allowances;
    }

    /**
     * @return
     */
    public function defaultAllowances()
    {
        return $this->default_allowances;
    }

    /**
     * @return
     */
    public function isSent()
    {
        return $this->is_sent;
    }

    public function getData(): array
    {
        return [
            'number_of_standard_working_days' => $this->number_of_standard_working_days,
            'number_of_probationary_working_days' => $this->number_of_probationary_working_days,
            'probationary_salary' => $this->probationary_salary,
            'number_of_official_working_days' => $this->number_of_official_working_days,
            'official_salary' => $this->official_salary,
            'number_of_probationary_working_days_on_holidays' => $this->number_of_probationary_working_days_on_holidays,
            'number_of_official_working_days_on_holidays' => $this->number_of_official_working_days_on_holidays,
            'number_of_probationary_working_days_on_weekly' => $this->number_of_probationary_working_days_on_weekly,
            'number_of_official_working_days_on_weekly' => $this->number_of_official_working_days_on_weekly,
            'total_working_days' => $this->total_working_days,
            'salary_by_working_day' => $this->salary_by_working_day,
            'lunch_allowance' => $this->lunch_allowance,
            'attendance_allowance' => $this->attendance_allowance,
            'child_care_allowance' => $this->child_care_allowance,
            'total_allowance' => $this->total_allowance,
            'sales_paid_to_employee' => $this->sales_paid_to_employee,
            'sales_salary' => $this->sales_salary,
            'kpi_sheet_id' => $this->kpi_sheet_id,
            'month_kpi' => $this->month_kpi,
            'total_p3_under_contract' => $this->total_p3_under_contract,
            'p3_month' => $this->p3_month,
            'quarterly_p3' => $this->quarterly_p3,
            'quarterly_p3_amount' => $this->quarterly_p3_amount,
            'p3_6_months' => $this->p3_6_months,
            'p3_6_months_amount' => $this->p3_6_months_amount,
            'real_p3_month' => $this->real_p3_month,
            'cumulative_quarterly_p3' => $this->cumulative_quarterly_p3,
            'total_income_before_tax' => $this->total_income_before_tax,
            'basic_salary' => $this->basic_salary,
            'enterprise_insurance_paid' => $this->enterprise_insurance_paid,
            'worker_insurance_paid' => $this->worker_insurance_paid,
            'personal_family_allowances' => $this->personal_family_allowances,
            'number_of_dependent_person' => $this->number_of_dependent_person,
            'dependent_person_deduction' => $this->dependent_person_deduction,
            'total_family_allowances' => $this->total_family_allowances,
            'total_deductions' => $this->total_deductions,
            'provisional_taxable_income' => $this->provisional_taxable_income,
            'personal_income_tax' => $this->personal_income_tax,
            'income_after_personal_income_tax' => $this->income_after_personal_income_tax,
            'cumulative_P3_bonus_paid_at_the_end_of_quarter_month' => $this->cumulative_P3_bonus_paid_at_the_end_of_quarter_month,
            'refund' => $this->refund,
            'bonus' => $this->bonus,
            'paying_the_contract_fines_withdrawn_beginning_year' => $this->paying_the_contract_fines_withdrawn_beginning_year,
            'internal_fund' => $this->internal_fund,
            'total_income' => $this->total_income,
            'fines_for_breaking_the_rules' => $this->fines_for_breaking_the_rules,
            'deduction' => $this->deduction,
            'penalty_for_late_withdrawal_of_the_contract' => $this->penalty_for_late_withdrawal_of_the_contract,
            'total_payment' => $this->total_payment,
            'last_month_income' => $this->last_month_income,
            'note' => $this->note,
            'max_lunch_allowance' => $this->max_lunch_allowance,
            'checkin_late' => $this->checkin_late,
            'checkout_early' => $this->checkout_early,
            'other_allowance_ids' => $this->other_allowance_ids,
            'other_allowances' => $this->other_allowances,
            'default_allowances' => $this->default_allowances,
            'gas' => $this->gas,
            'is_sent' => $this->is_sent,
        ];
    }
}
