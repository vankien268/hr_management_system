<?php


namespace App\Models;


class StatisticWorkingShiftObject
{
    /**
     * Identifer: shift_id
     */
    public ?int $identity;

    /**
     * @var int|null [WORKING_SHIFT_TYPE_FULL_TIME|WORKING_SHIFT_TYPE_PART_TIME] (*)
     * Loại ca làm việc: full time hoặc part time
     */
    public ?int $shift_type;

    public ?string $shift_title;

    public ?string $description;

    /**
     * @var int|null [0|1]
     *
     * Enable/Disable ca làm việc
     */
    public ?int $active;

    /**
     * @var [
     *     (int) is_working,
     *     [string time (H:i)] shift_start_time,
     *     [string time (H:i)] shift_end_time,
     *     [double] upper_wage_percent
     * ] (*)
     * Ngày làm việc trong tuần (T2 - CN)
     */
    public $shift_weekdays;

    /**
     * @var string (H:i)
     * Thời gian bắt đầu ca làm việc trong ngày
     * Nếu start_time không có trong $shift_weekdays thì lấy trong $start_time với điều kiện $shift_weekdays[is_working] = 1
     */
    private string $shift_start_time;

    /**
     * @var [string time (H:i)]
     * Thời gian kết thúc ca làm việc trong ngày
     * Nếu end_time không có trong $shift_weekdays thì lấy trong $end_time với điều kiện $shift_weekdays[is_working] = 1
     */
    private string $shift_end_time;

    /**
     * @atribute double (*)
     * Số công làm việc
     */
    public float $work_number;


    /**
     * @atribute int
     * Số phút cho phép check in muộn
     */
    public int $check_in_late;

    /**
     * @atribute int
     * Số phút cho phép check out sớm
     */
    public int $check_out_early;

    /**
     * @atribute: int [0|1] (default: 1)
     * Cơ chế chấm công nghiêm ngặt (chỉ áp dụng cho part time)
     * + Enable (default): Lương chỉ được tính khi chấm công đúng giờ
     * + Disable: Lương được tính theo thời gian thực tế (phụ thuộc vào $use_free_timekeeping)
     */
    public int $use_strict_timekeeping;

    /**
     * @atribute int [0|1] (default: 0)
     * Cơ chế chấm công tự do (chỉ có nghĩa khi disable $use_strict_timekeeping)
     * + Enable: Lương được tính từ thời điểm check in => check out
     * + Disable: Lương được tính từ thời điểm check in => kết thúc ca làm việc nếu
     *            + Thời điểm chấm ra >= (thời gian kết thúc ca làm việc - số phút cho phép về sớm)
     *            Ngược lại: lương được tính từ thời điểm checkin > checkout
     */
    public int $use_free_timekeeping;

    public function setInputData(array $inputData)
    {
        $this->assignInput($inputData);
        $this->parseInput();

        return $this;
    }

    /**
     * Gán inputData (từ end user hoặc database) vào object
     * @param array $input_data
     *
     * @return void
     */
    public function assignInput(array $input_data)
    {
        $this->identity =   $this->valueOrNull($input_data, 'shift_id');

        $this->shift_type =   $this->valueOrNull($input_data, 'shift_type');
        $this->shift_title =   $this->valueOrNull($input_data, 'shift_title');
        $this->description =   $this->valueOrNull($input_data, 'description');
        $this->active =   $this->valueOrNull($input_data, 'active');
        $this->work_number =   $this->valueOrNull($input_data, 'work_number');
        $this->wage_per_work =   $this->valueOrNull($input_data, 'wage_per_work');
        $this->check_in_late =   $this->valueOrNull($input_data, 'check_in_late');
        $this->check_out_early =   $this->valueOrNull($input_data, 'check_out_early');
        $this->use_strict_timekeeping =   $this->valueOrNull($input_data, 'use_strict_timekeeping');
        $this->use_free_timekeeping =   $this->valueOrNull($input_data, 'use_free_timekeeping');
        $this->shift_weekdays = $input_data['shift_weekdays'] ?? [];
    }

    public function  valueOrNull($item, $key)
    {
        $value = null;

        if (is_array($item) && isset($item[$key])) {
            $value = $item[$key];
        } elseif (is_object($item) && isset($item->{$key})) {
            $value = $item->{$key};
        }

        return $value;
    }

    public function intOrOriginal($value)
    {
        return ctype_digit((string) $value) ? (int) $value : $value;
    }

    public function numberOrOriginal($value)
    {
        if (ctype_digit((string) $value)) {
            return (int) $value;
        }

        return is_numeric($value) ? (double) $value : $value;
    }

    public function isJsonString($value)
    {
        return (is_string($value) && ! is_numeric($value) && json_decode($value, false) !== null);
    }

    /**
     * Phân tích object elements và convert sang kiểu dữ liệu thích hợp
     * (Note: Không làm mất mát dữ liệu. VD: (int) '123abc' = 123 là mất mát dữ liệu)
     *
     * @return void
     */
    public function parseInput()
    {
        $this->identity =   $this->intOrOriginal($this->identity);
        $this->shift_type =   $this->intOrOriginal($this->shift_type);
        $this->active =   $this->intOrOriginal($this->active);
        $this->work_number =   $this->numberOrOriginal($this->work_number);
        $this->wage_per_work =   $this->numberOrOriginal($this->wage_per_work);

        $this->check_in_late =   $this->numberOrOriginal($this->check_in_late);
        $this->check_out_early =   $this->numberOrOriginal($this->check_out_early);

        $this->use_strict_timekeeping =   $this->intOrOriginal($this->use_strict_timekeeping);
        $this->use_free_timekeeping =   $this->intOrOriginal($this->use_free_timekeeping);

        $isShiftWeekDaysFormatted = false;

        if ($this->isJsonString($this->shift_weekdays)) {
            $isShiftWeekDaysFormatted = true;
            $this->shift_weekdays = json_decode($this->shift_weekdays, false);
        } elseif (is_array($this->shift_weekdays)) {
            $isShiftWeekDaysFormatted = true;
            $this->shift_weekdays = (object) $this->shift_weekdays;

            foreach ($this->shift_weekdays as $weekday => $info) {
                $this->shift_weekdays->{$weekday} = (object) $info;
            }
        }

        if ($isShiftWeekDaysFormatted) {
            foreach ($this->shift_weekdays as $weekday => $info) {
                if (isset($info->is_working)) {
                    $info->is_working =   $this->intOrOriginal($info->is_working);
                }

                if (isset($info->upper_wage_percent)) {
                    $info->upper_wage_percent =   $this->numberOrOriginal($info->upper_wage_percent);
                }
            }
        }
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return array_merge($this->getSingleFields(), $this->getAttributeFields(), $this->getWeekDaysFields());
    }

    /**
     * Lấy ra trường dữ liệu đơn giản (logic database)
     */
    public function getSingleFields(): array
    {
        return [
            'identity' => $this->identity,
            'shift_type' => $this->shift_type,
            'shift_title' => $this->shift_title,
            'description' => $this->description,
            'active' => $this->active
        ];
    }

    /**
     * @return array
     */
    public function getAttributeFields(): array
    {
        return [
            'work_number' => $this->work_number,
            'wage_per_work' => $this->wage_per_work,
            'check_in_late' => $this->check_in_late,
            'check_out_early' => $this->check_out_early,
            'use_strict_timekeeping' => $this->use_strict_timekeeping,
            'use_free_timekeeping' => $this->use_free_timekeeping
        ];
    }

    /**
     * @return string[]
     */
    public function getAttributeKeys(): array
    {
        return [
            'work_number',
            'wage_per_work',
            'check_in_late',
            'check_out_early',
            'use_strict_timekeeping',
            'use_free_timekeeping'
        ];
    }

    /**
     * @return array
     */
    public function getWeekDaysFields(): array
    {
        return [
            'shift_weekdays' => $this->shift_weekdays,
            'shift_start_time' => $this->shift_start_time,
            'shift_end_time' => $this->shift_end_time
        ];
    }
}
