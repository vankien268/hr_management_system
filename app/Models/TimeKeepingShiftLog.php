<?php


namespace App\Models;


class TimeKeepingShiftLog
{
    /**
     *
     * Ngày làm việc hiện tại trong tuần: [monday - sunday]
     */
    public string $today;

    /**
     * @var object|null $shift_weekday
     *
     * Thông tin ngày làm việc trong ngày $today được thiết lập (JSON)
     */
    public ?object $shift_weekday;

    /**
     * @var object|null $info
     *
     * Thông tin thiết lập ca làm việc hiện tại (JSON)
     */
    public ?object $info;

    public function __construct(array $attributes = [])
    {
        $this->today = $attributes['today'] ?? null;
        $this->shift_weekday = $attributes['shift_weekday'] ?? null;
        $this->info = $attributes['info'] ?? null;
    }
}
