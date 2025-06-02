<?php


namespace App\Models;


class RequestTicketResult
{
    CONST ANNUAL_LEAVE = 'annual_leave';                            # Nghỉ kiểu bình thường
    CONST UNPAID_LEAVE = 'unpaid_leave';                            # Nghỉ không lương
    CONST REGIME_LEAVE = 'regime_leave';                            # Nghỉ chế độ
    CONST BUSINESS_TRAVEL = 'business_travel';                      # Đi công tác
    CONST WORKING_OUT_OF_THE_OFFICE = 'working_out_of_the_office';  # Làm việc ngoài văn phòng
}
