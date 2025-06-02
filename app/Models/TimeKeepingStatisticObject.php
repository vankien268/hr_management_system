<?php


namespace App\Models;


class TimeKeepingStatisticObject
{
    # Tổng số phút đi sớm
    public    $checkin_early_minutes = 0;

    # Tổng số phút đi muộn
    public    $checkin_late_minutes = 0;

    # Tổng số phút về sớm
    public    $checkout_early_minutes = 0;

    # Tổng số phút về muộn
    public    $checkout_late_minutes = 0;

    # Tổng số lần đi sớm
    public    $total_checkin_early = 0;

    # Tổng số lần đi muộn
    public    $total_checkin_late = 0;

    # Tổng số lần về sớm
    public    $total_checkout_early = 0;

    # Tổng số lần về muộn
    public    $total_checkout_late = 0;

    # Tổng số vắng có phép
    public    $total_excused_absence = 0;

    # Tổng số vắng không phép
    public    $total_unexcused_absence = 0;

    # Tổng công
    public    $total_work_number = 0;

    # Tổng số ngày đi làm
    public    $total_working_days = 0;


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

    public function reset()
    {
        $this->checkin_early_minutes = 0;
        $this->checkin_late_minutes = 0;
        $this->checkout_early_minutes = 0;
        $this->checkout_late_minutes = 0;

        $this->total_checkin_early = 0;
        $this->total_checkin_late = 0;
        $this->total_checkout_early = 0;
        $this->total_checkout_late = 0;

        $this->total_excused_absence = 0;
        $this->total_unexcused_absence = 0;

        $this->total_work_number = 0;
        $this->total_working_days = 0;
    }

    public function round()
    {
        $this->checkin_early_minutes = round($this->checkin_early_minutes);
        $this->checkin_late_minutes = round($this->checkin_late_minutes);
        $this->checkout_early_minutes = round($this->checkout_early_minutes);
        $this->checkout_late_minutes = round($this->checkout_late_minutes);
        $this->total_checkin_early = round($this->total_checkin_early);
        $this->total_checkin_late = round($this->total_checkin_late);
        $this->total_checkout_early = round($this->total_checkout_early);
        $this->total_checkout_late = round($this->total_checkout_late);
        $this->total_excused_absence = round($this->total_excused_absence, 2);
        $this->total_unexcused_absence = round($this->total_unexcused_absence, 2);

        return $this;
    }

    public function getData(array $properties = [])
    {
        return [
            'checkin_early_minutes' => $this->checkin_early_minutes,
            'checkin_late_minutes' => $this->checkin_late_minutes,
            'checkout_early_minutes' => $this->checkout_early_minutes,
            'checkout_late_minutes' => $this->checkout_late_minutes,
            'total_checkin_early' => $this->total_checkin_early,
            'total_checkin_late' => $this->total_checkin_late,
            'total_checkout_early' => $this->total_checkout_early,
            'total_checkout_late' => $this->total_checkout_late,
            'total_excused_absence' => $this->total_excused_absence,
            'total_unexcused_absence' => $this->total_unexcused_absence,
            'total_work_number' => $this->total_work_number,
            'total_working_days' => $this->total_working_days,
        ];
    }
}
