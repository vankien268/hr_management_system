<?php

namespace App\Biz\Newway\Excel;

use App\Biz\Newway\Excel\NumberFormat as ExcelNumberFormat;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportExcel extends Controller implements
    FromView,
    ShouldAutoSize,
    WithDrawings,
    WithEvents,
    WithColumnWidths,
    WithStyles,
    WithColumnFormatting
{
    private $view;
    private $hotelLogo;
    private $argument;

    public function __construct(View $view, ...$theArgs)
    {
        $this->view = $view;
        // $this->hotelLogo = $hotelLogo;
        $this->argument = $theArgs;
    }

    /**
     * view blade
     *
     * @return View
     */
    public function view(): View
    {
        return $this->view;
    }
    public function drawings()
    {

        $drawing = new Drawing();
        $drawing->setName("Logo");
        $drawing->setDescription("This is my logo");
        $drawing->setPath(
            public_path("/assets/media/logos/newway.png")
        );
        $drawing->setHeight(55);
        $drawing->setCoordinates("A1");
        // $drawing->setOffsetX(20);
        $drawing->setOffsetY(2);
        return $drawing;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet
                    ->getDelegate()
                    ->getRowDimension("1")
                    ->setRowHeight(50);

                if (in_array("reportByCustomer", $this->argument)) {
                    //bg color
                    $event->sheet
                        ->getDelegate()
                        ->getStyle(
                            "A2:" .
                                $event->sheet->getHighestDataColumn() .
                                $event->sheet->getHighestRow()
                        )
                        ->getFill()
                        ->setFillType(
                            \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
                        )
                        ->getStartColor()
                        ->setARGB("FFFFFF");
                    //border
                    $event->sheet
                        ->getStyle(
                            "A1:" .
                                $event->sheet->getHighestDataColumn() .
                                $event->sheet->getHighestRow()
                        )
                        ->applyFromArray([
                            "borders" => [
                                "allBorders" => [
                                    "borderStyle" =>
                                    \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                    "color" => ["argb" => "000000"],
                                    "setBorder" => 10
                                ],
                            ],
                        ]);
                    $event->sheet->getStyle(
                        "H3:" .
                            $event->sheet->getHighestDataColumn() .
                            $event->sheet->getHighestRow()
                    )->getAlignment()->setWrapText(true);
                }
                if (in_array("reportByProject", $this->argument)) {
                    //bg color
                    $event->sheet
                        ->getDelegate()
                        ->getStyle(
                            "A2:" .
                                $event->sheet->getHighestDataColumn() .
                                $event->sheet->getHighestRow()
                        )
                        ->getFill()
                        ->setFillType(
                            \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
                        )
                        ->getStartColor()
                        ->setARGB("FFFFFF");
                    //border
                    $event->sheet
                        ->getStyle(
                            "A1:" .
                                $event->sheet->getHighestDataColumn() .
                                $event->sheet->getHighestRow()
                        )
                        ->applyFromArray([
                            "borders" => [
                                "allBorders" => [
                                    "borderStyle" =>
                                    \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                    "color" => ["argb" => "000000"],
                                ],
                            ],
                        ]);
                    //word-break
                    $event->sheet->getStyle(
                        "H3:" .
                            $event->sheet->getHighestDataColumn() .
                            $event->sheet->getHighestRow()
                    )->getAlignment()->setWrapText(true);
                }
                if (in_array("reportByContract", $this->argument)) {
                    //bg color
                    $event->sheet
                        ->getDelegate()
                        ->getStyle(
                            "A2:" .
                                $event->sheet->getHighestDataColumn() .
                                $event->sheet->getHighestRow()
                        )
                        ->getFill()
                        ->setFillType(
                            \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
                        )
                        ->getStartColor()
                        ->setARGB("FFFFFF");
                    //border
                    $event->sheet
                        ->getStyle(
                            "A1:" .
                                $event->sheet->getHighestDataColumn() .
                                $event->sheet->getHighestRow()
                        )
                        ->applyFromArray([
                            "borders" => [
                                "allBorders" => [
                                    "borderStyle" =>
                                    \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                    "color" => ["argb" => "000000"],
                                ],
                            ],
                        ]);
                }
                if (in_array("reportByDispatch", $this->argument)) {
                    //bg color
                    $event->sheet
                        ->getDelegate()
                        ->getStyle(
                            "A2:J" .
                                // $event->sheet->getHighestDataColumn() .
                                $event->sheet->getHighestRow()
                        )
                        ->getFill()
                        ->setFillType(
                            \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
                        )
                        ->getStartColor()
                        ->setARGB("FFFFFF");
                    //border
                    $event->sheet
                        ->getStyle(
                            "A1:" .
                                $event->sheet->getHighestDataColumn() .
                                $event->sheet->getHighestRow()
                        )
                        ->applyFromArray([
                            "borders" => [
                                "allBorders" => [
                                    "borderStyle" =>
                                    \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                    "color" => ["argb" => "000000"],
                                ],
                            ],
                        ]);
                    //word-break
                    $event->sheet->getStyle(
                        "I5:J" .
                            // $event->sheet->getHighestDataColumn() .
                            $event->sheet->getHighestRow()
                    )->getAlignment()->setWrapText(true);
                    $event->sheet->getStyle(
                        "J5:J" .
                            // $event->sheet->getHighestDataColumn() .
                            $event->sheet->getHighestRow()
                    )->getAlignment()->setWrapText(true);
                }
                if (in_array("reportByPaymentDetailContract", $this->argument)) {
                    //bg color
                    $event->sheet
                        ->getDelegate()
                        ->getStyle(
                            "A2:" .
                                $event->sheet->getHighestDataColumn() .
                                $event->sheet->getHighestRow()
                        )
                        ->getFill()
                        ->setFillType(
                            \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
                        )
                        ->getStartColor()
                        ->setARGB("FFFFFF");
                    //border
                    $event->sheet
                        ->getStyle(
                            "A1:" .
                                $event->sheet->getHighestDataColumn() .
                                $event->sheet->getHighestRow()
                        )
                        ->applyFromArray([
                            "borders" => [
                                "allBorders" => [
                                    "borderStyle" =>
                                    \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                    "color" => ["argb" => "000000"],
                                ],
                            ],
                        ]);
                    //word-break
                    $event->sheet->getStyle(
                        "H5:" .
                            $event->sheet->getHighestDataColumn() .
                            $event->sheet->getHighestRow()
                    )->getAlignment()->setWrapText(true);
                }
                if (in_array("reportByAcceptanceRecord", $this->argument)) {
                    //bg color
                    $event->sheet
                        ->getDelegate()
                        ->getStyle(
                            "A2:" .
                                $event->sheet->getHighestDataColumn() .
                                $event->sheet->getHighestRow()
                        )
                        ->getFill()
                        ->setFillType(
                            \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
                        )
                        ->getStartColor()
                        ->setARGB("FFFFFF");
                    //border
                    $event->sheet
                        ->getStyle(
                            "A1:" .
                                $event->sheet->getHighestDataColumn() .
                                $event->sheet->getHighestRow()
                        )
                        ->applyFromArray([
                            "borders" => [
                                "allBorders" => [
                                    "borderStyle" =>
                                    \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                    "color" => ["argb" => "000000"],
                                ],
                            ],
                        ]);
                    $event->sheet->getStyle(
                        "J4:" .
                            $event->sheet->getHighestDataColumn() .
                            $event->sheet->getHighestRow()
                    )->getAlignment()->setWrapText(true);
                }
                if (in_array("reportByDeploymentRecord", $this->argument)) {
                    //bg color
                    $event->sheet
                        ->getDelegate()
                        ->getStyle(
                            "A2:" .
                                $event->sheet->getHighestDataColumn() .
                                $event->sheet->getHighestRow()
                        )
                        ->getFill()
                        ->setFillType(
                            \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID
                        )
                        ->getStartColor()
                        ->setARGB("FFFFFF");
                    //border
                    $event->sheet
                        ->getStyle(
                            "A1:" .
                                $event->sheet->getHighestDataColumn() .
                                $event->sheet->getHighestRow()
                        )
                        ->applyFromArray([
                            "borders" => [
                                "allBorders" => [
                                    "borderStyle" =>
                                    \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                    "color" => ["argb" => "000000"],
                                ],
                            ],
                        ]);
                    $event->sheet->getStyle(
                        "F4:" .
                            $event->sheet->getHighestDataColumn() .
                            $event->sheet->getHighestRow()
                    )->getAlignment()->setWrapText(true);
                }
            },
        ];
    }
    public function columnWidths(): array
    {
        // if (in_array("reportByContract", $this->argument)) {
        //     return [
        //         "A" => 50,
        //     ];
        // }
        // if (
        //     in_array("bookingExtendDate", $this->argument) ||
        //     in_array("bookingGoSoon", $this->argument) ||
        //     in_array("bookingHUCOM", $this->argument)
        // ) {
        //     return [
        //         "A" => 7,
        //     ];
        // }
        // if (
        //     in_array("BreakfastReport", $this->argument)
        // ) {
        //     return [
        //         "A" => 7,
        //         "N" => 12,
        //         "o" => 12
        //     ];
        // }
        if (
            in_array("reportByAcceptanceRecord", $this->argument)
        ) {
            return [
                "A" => 22,
            ];
        }
        return [
            "A" => 10,
        ];
    }
    public function styles(Worksheet $sheet)
    {
        $data = [];
        if (in_array("lateCheckin", $this->argument)) {
            return [
                // Style the first row as bold text.
                2 => [
                    "font" => ["bold" => true, "size" => 14],
                ],
                $sheet->getHighestRow() => [
                    "font" => ["bold" => true, "size" => 12],
                ],
                "G1" => [
                    "font" => ["bold" => true, "size" => 14],
                ],
            ];
        }
        if (
            in_array("bookingExtendDate", $this->argument) ||
            in_array("bookingGoSoon", $this->argument) ||
            in_array("bookingUnassignedRoom", $this->argument) ||
            in_array("bookingHUCOM", $this->argument)

        ) {
            return [
                // Style the first row as bold text.
                3 => [
                    "font" => ["bold" => false, "size" => 12],
                ],
                $sheet->getHighestRow() => [
                    "font" => ["bold" => true, "size" => 12],
                ],
                "F1" => [
                    "font" => ["bold" => true, "size" => 16],
                ],
            ];
        }
        return $data;
    }
    public function columnFormats(): array
    {
        if (in_array("reportByCustomer", $this->argument)) {
            return [];
        }
        if (in_array("reportByProject", $this->argument)) {
            return [];
        }
        if (in_array("reportByContract", $this->argument)) {
            return [];
        }
        if (in_array("reportByDispatch", $this->argument)) {
            return [];
        }
        if (in_array("reportByPaymentDetailContract", $this->argument)) {
            return [];
        }
        if (in_array("reportByAcceptanceRecord", $this->argument)) {
            return [];
        }
        if (in_array("reportByDeploymentRecord", $this->argument)) {
            return [];
        }
        return [
            "K" => ExcelNumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            "J" => ExcelNumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            "L" => ExcelNumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            "N" => ExcelNumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            "G" => ExcelNumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            "I" => ExcelNumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            "F" => ExcelNumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            "H" => ExcelNumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }
}
