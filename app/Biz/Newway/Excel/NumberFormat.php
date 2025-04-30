<?php
namespace App\Biz\Newway\Excel;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat as StyleNumberFormat;

class NumberFormat extends StyleNumberFormat
{
     const FORMAT_NUMBER_COMMA_SEPARATED1 = '#,##0';
     const FORMAT_DECIMAL_COMMA_SEPARATED2 = '#,##0.00';
    const FORMAT_NUMBER_COMMA_SEPARATED2 = '#,##0.00_-';
}
?>
