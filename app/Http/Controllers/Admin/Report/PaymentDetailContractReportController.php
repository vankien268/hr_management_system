<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\IPaymentDetailRepository;
use App\Repositories\Interfaces\IProjectManagementRepository;
use App\Repositories\Interfaces\IContractRepository;
use App\Repositories\Interfaces\ISystemStatusRepository;
use App\Transformers\ContractReportTransformer;
use App\Transformers\ProjectManagementTransformer;
use App\Transformers\ContractTransformer;
use App\Transformers\SystemStatusTransformer;
use App\Biz\Newway\Excel\ExportExcel;
use App\Enums\ProjectPermissionEnum;
use App\Enums\SystemPermissionEnum;

use function App\Helper\check_user_permission;
// use Excel;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

class PaymentDetailContractReportController extends Controller
{
    protected $paymentDetailContractReportRepository;
    protected $paymentDetailRepository;
    protected $projectManagementRepository;
    protected $contractRepository;
    protected $systemStatusRepository;
    public function __construct(
        IContractRepository $paymentDetailContractReportRepository,
        IPaymentDetailRepository $paymentDetailRepository,
        IProjectManagementRepository $projectManagementRepository,
        IContractRepository $contractRepository,
        ISystemStatusRepository $systemStatusRepository,
    ) {
        $this->paymentDetailContractReportRepository = $paymentDetailContractReportRepository;
        $this->paymentDetailRepository = $paymentDetailRepository;
        $this->projectManagementRepository = $projectManagementRepository;
        $this->contractRepository = $contractRepository;
        $this->systemStatusRepository = $systemStatusRepository;
    }

    public function index()
    {
        return view(
            'admin.reports.payment-detail-contracts.index',
            [
                'hideHeader' => true,
            ]
        );
    }

    public function getAllPaymentDetails(Request $request)
    {
        $perPage = $request->per_page;
        if (!$perPage) {
            $perPage = 30;
        }

        $expected_payment_from_date = $request->expected_payment_from_date;
        $expected_payment_to_date = $request->expected_payment_to_date;
        $payment_date_from_date = $request->payment_date_from_date;
        $payment_date_to_date = $request->payment_date_to_date;
        $project_id = $request->project_id;
        $contract_id = $request->contract_id;
        $status_id = $request->status_id;

        // quyền dự án và xem tiến độ thanh toán hợp đồng của user có
        $getAllPermisisonProject = $this->contractRepository->model()->userPermissions();
        $projectIds = [];
        foreach ($getAllPermisisonProject as $projectId => $permissions) {
            if (in_array(ProjectPermissionEnum::VIEW_DETAIL_PAYMENT_CONTRACT, $permissions)) {
                $projectIds[] = $projectId;
            }
        }
        //query
        $getPaymentDetails = $this->projectManagementRepository->model()
            ->with(
                [
                    'contracts' => function ($q) use ($expected_payment_from_date, $expected_payment_to_date, $payment_date_from_date, $payment_date_to_date, $contract_id) {
                        $q->with("paymentDetails", function ($qPaymentDetail) use ($expected_payment_from_date, $expected_payment_to_date, $payment_date_from_date, $payment_date_to_date, $contract_id) {
                            //ngay thanh toan thuc te
                            if ($payment_date_from_date) {
                                $qPaymentDetail->whereDate('payment_date', '>=', $payment_date_from_date);
                            }
                            if ($payment_date_to_date) {
                                $qPaymentDetail->whereDate('payment_date', '<=', $payment_date_to_date);
                            }
                            //ngay thanh toan du kien
                            if ($expected_payment_from_date) {
                                $qPaymentDetail->whereDate('expected_payment_date', '>=', $expected_payment_from_date);
                            }
                            if ($expected_payment_to_date) {
                                $qPaymentDetail->whereDate('expected_payment_date', '<=', $expected_payment_to_date);
                            }
                        })->whereHas('paymentDetails', function ($qPaymentDetail) use ($expected_payment_from_date, $expected_payment_to_date, $payment_date_from_date, $payment_date_to_date, $contract_id) {
                            //ngay thanh toan thuc te
                            if ($payment_date_from_date) {
                                $qPaymentDetail->whereDate('payment_date', '>=', $payment_date_from_date);
                            }
                            if ($payment_date_to_date) {
                                $qPaymentDetail->whereDate('payment_date', '<=', $payment_date_to_date);
                            }
                            //ngay thanh toan du kien
                            if ($expected_payment_from_date) {
                                $qPaymentDetail->whereDate('expected_payment_date', '>=', $expected_payment_from_date);
                            }
                            if ($expected_payment_to_date) {
                                $qPaymentDetail->whereDate('expected_payment_date', '<=', $expected_payment_to_date);
                            }
                        });

                        if ($contract_id) {
                            $q->where('id', '=', $contract_id);
                        }
                    }
                ]
            )->where(function($query) use($projectIds){
                if(!check_user_permission(SystemPermissionEnum::SYSTEM_EDIT_CONTRACT)) {
                    $query->whereIn('id', $projectIds);
                }
            })
            ->where(function ($query) use (
                $expected_payment_from_date,
                $expected_payment_to_date,
                $payment_date_from_date,
                $payment_date_to_date,
                $project_id,
                $contract_id,
                $status_id,
            ) {
                if ($project_id) {
                    $query->where('id', '=', $project_id);
                }

                if ($contract_id) {
                    $query->whereHas('contracts', function ($q) use ($contract_id) {
                        $q->where('id', '=', $contract_id);
                    });
                }
                // if ($status_id) {
                //     $query->whereHas('systemStatus', function ($q) use ($status_id) {
                //             $q->whereDate('id', '=', $status_id);
                //     });
                // }
            })

            ->paginate($perPage);
        $this->setTransformer(new ProjectManagementTransformer(true));
        $expected_payment_from_date = $request->expected_payment_from_date;
        $expected_payment_to_date = $request->expected_payment_to_date;
        $payment_date_from_date = $request->payment_date_from_date;
        $payment_date_to_date = $request->payment_date_to_date;
        $project_id = $request->project_id;
        $contract_id = $request->contract_id;
        $status_id = $request->status_id;
        $dataExportExcel = [
            'expected_payment_from_date' => $expected_payment_from_date,
            'expected_payment_to_date' => $expected_payment_to_date,
            'payment_date_from_date' => $payment_date_from_date,
            'payment_date_to_date' => $payment_date_to_date,
            'project_id' => $project_id,
            'contract_id' => $contract_id,
            'status_id' => $status_id,
        ];
        $urlExport = route('admin.payment-detail-contract.exportExcel', $dataExportExcel);
        return $this->responsePaginatedCollection($getPaymentDetails, 200, [
            'url_export' => $urlExport
        ]);
    }

    public function getOther(Request $request)
    {
        $getProjects = $this->projectManagementRepository->model()->orderBy('id')->get();
        $this->setTransformer(new ProjectManagementTransformer(true));
        $getContracts = $this->contractRepository->model()->orderBy('id')->get();
        $this->setTransformer(new ContractTransformer(true));
        $getSystemStatuses = $this->systemStatusRepository->model()->orderBy('id')->get();
        $this->setTransformer(new SystemStatusTransformer(true));
        return response()->json([
            'getProjects' => $getProjects,
            'getContracts' => $getContracts,
            'getSystemStatuses' => $getSystemStatuses,
        ], 200);
    }

    public function exportExcel(Request $request)
    {
        $expected_payment_from_date = $request->expected_payment_from_date;
        $expected_payment_to_date = $request->expected_payment_to_date;
        $payment_date_from_date = $request->payment_date_from_date;
        $payment_date_to_date = $request->payment_date_to_date;
        $project_id = $request->project_id;
        $contract_id = $request->contract_id;
        $status_id = $request->status_id;
        $data = [
            'userIn' => auth()->user()->name,
            'dateIn' => date('d/m/Y - H:i'),
            'reportName' => 'BÁO CÁO TIẾN ĐỘ THANH TOÁN HỢP ĐỒNG',
            'cpnName' => 'Công ty cổ phần giải pháp công nghệ Newway',
            'cpnAddress' => '74 Hồ Đền Lừ, Hoàng Mai, Hà Nội',
            'expected_payment_from_date' => $expected_payment_from_date,
            'expected_payment_to_date' => $expected_payment_to_date,
            'payment_date_from_date' => $payment_date_from_date,
            'payment_date_to_date' => $payment_date_to_date,
            'project_id' => $project_id,
            'contract_id' => $contract_id,
            'status_id' => $status_id,
        ];

        $getExportPaymentDetails = $this->projectManagementRepository->model()
        ->with(
            [
                'contracts' => function ($q) use ($expected_payment_from_date, $expected_payment_to_date, $payment_date_from_date, $payment_date_to_date, $contract_id) {
                    $q->with("paymentDetails", function ($qPaymentDetail) use ($expected_payment_from_date, $expected_payment_to_date, $payment_date_from_date, $payment_date_to_date, $contract_id) {
                        //ngay thanh toan thuc te
                        if ($payment_date_from_date) {
                            $qPaymentDetail->whereDate('payment_date', '>=', $payment_date_from_date);
                        }
                        if ($payment_date_to_date) {
                            $qPaymentDetail->whereDate('payment_date', '<=', $payment_date_to_date);
                        }
                        //ngay thanh toan du kien
                        if ($expected_payment_from_date) {
                            $qPaymentDetail->whereDate('expected_payment_date', '>=', $expected_payment_from_date);
                        }
                        if ($expected_payment_to_date) {
                            $qPaymentDetail->whereDate('expected_payment_date', '<=', $expected_payment_to_date);
                        }
                    })->whereHas('paymentDetails', function ($qPaymentDetail) use ($expected_payment_from_date, $expected_payment_to_date, $payment_date_from_date, $payment_date_to_date, $contract_id) {
                        //ngay thanh toan thuc te
                        if ($payment_date_from_date) {
                            $qPaymentDetail->whereDate('payment_date', '>=', $payment_date_from_date);
                        }
                        if ($payment_date_to_date) {
                            $qPaymentDetail->whereDate('payment_date', '<=', $payment_date_to_date);
                        }
                        //ngay thanh toan du kien
                        if ($expected_payment_from_date) {
                            $qPaymentDetail->whereDate('expected_payment_date', '>=', $expected_payment_from_date);
                        }
                        if ($expected_payment_to_date) {
                            $qPaymentDetail->whereDate('expected_payment_date', '<=', $expected_payment_to_date);
                        }
                    });

                    if ($contract_id) {
                        $q->where('id', '=', $contract_id);
                    }
                }
            ]
        )
        ->where(function ($query) use (
            $expected_payment_from_date,
            $expected_payment_to_date,
            $payment_date_from_date,
            $payment_date_to_date,
            $project_id,
            $contract_id,
            $status_id,
        ) {
            if ($project_id) {
                $query->where('id', '=', $project_id);
            }

            if ($contract_id) {
                $query->whereHas('contracts', function ($q) use ($contract_id) {
                    $q->where('id', '=', $contract_id);
                });
            }
            // if ($status_id) {
            //     $query->whereHas('systemStatus', function ($q) use ($status_id) {
            //             $q->whereDate('id', '=', $status_id);
            //     });
            // }
        })

        ->get();
    $this->setTransformer(new ProjectManagementTransformer(true));
        $view = view('excel.report-payment-detail-contract', [
            'data' => $data,
            'getExportPaymentDetails' => $getExportPaymentDetails,
        ]);

        return FacadesExcel::download(
            new ExportExcel($view, 'reportByPaymentDetailContract'),
            "report-by-payment-detail-contract.xlsx"
        );
    }
}
