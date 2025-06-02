<?php


namespace App\Models;


class ShiftWeekdayObject
{
    /**
     * @var int
     */
    public int $is_working;

    /**
     * Thời gian bắt đầu ca làm việc
     *
     * @var string|null
     */
    public ?string $shift_start_time;

    /**
     * Thời gian kết thúc ca làm việc
     *
     * @var string|null
     */
    public ?string $shift_end_time;

    /**
     * Lương cộng thêm / Công
     *
     * @var float|null
     */
    public ?float $upper_wage_percent;

    public function __construct(array $data = [])
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
}
