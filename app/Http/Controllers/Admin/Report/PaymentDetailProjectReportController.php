<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\IPaymentDetailRepository;
use App\Repositories\Interfaces\IProjectManagementRepository;
use App\Repositories\Interfaces\IContractRepository;
use App\Repositories\Interfaces\ISystemStatusRepository;
use App\Transformers\ContractReportTransformer;
use App\Transformers\PaymentDetailReportTransformer;
use App\Transformers\ProjectManagementTransformer;
use App\Transformers\ContractTransformer;
use App\Transformers\SystemStatusTransformer;

class PaymentDetailProjectReportController extends Controller
{
    protected $contractReportRepository;
    protected $paymentDetailRepository;
    protected $projectManagementRepository;
    protected $contractRepository;
    protected $systemStatusRepository;
    public function __construct(
        IContractRepository $contractReportRepository,
        IPaymentDetailRepository $paymentDetailRepository,
        IProjectManagementRepository $projectManagementRepository,
        IContractRepository $contractRepository,
        ISystemStatusRepository $systemStatusRepository,
    )
    {
        $this->contractReportRepository = $contractReportRepository;
        $this->paymentDetailRepository = $paymentDetailRepository;
        $this->projectManagementRepository = $projectManagementRepository;
        $this->contractRepository = $contractRepository;
        $this->systemStatusRepository = $systemStatusRepository;
    }

    public function index()
    {
        return view('admin.reports.payment-detail-projects.index',
    [
        'hideHeader' => true,
    ]);
    }

    public function getAllPaymentDetailProjects(Request $request)
    {
        $perPage = $request->per_page;
        if (!$perPage) {
            $perPage = 30;
        }

        $expected_payment_from_date	 = $request->expected_payment_from_date;
        $expected_payment_to_date = $request->expected_payment_to_date;
        $project_id = $request->project_id;
        $contract_id = $request->contract_id;
        $status_id = $request->status_id;
        $getPaymentDetails = $this->contractReportRepository->model()
            ->with(['project','customer',
            'paymentDetails'=> function($q) use($expected_payment_from_date,$expected_payment_to_date){
                if($expected_payment_from_date){
                    $q->whereDate('payment_date', '>=', $expected_payment_from_date);
                }
                if($expected_payment_to_date){
                    $q->whereDate('payment_date', '<=', $expected_payment_to_date);
                }

            }])
            ->where(function ($query) use (
                $expected_payment_from_date,
                $expected_payment_to_date,
                $project_id,
                $contract_id,
                $status_id,
            ) {
                if($expected_payment_from_date) {
                    $query->whereHas('paymentDetails', function($q) use($expected_payment_from_date){
                        $q->whereDate('payment_date', '>=', $expected_payment_from_date);
                    });
                }
                if($expected_payment_to_date) {
                    $query->whereHas('paymentDetails', function($q) use($expected_payment_to_date){
                        $q->whereDate('payment_date', '<=', $expected_payment_to_date);
                    });
                }
                if ($project_id) {
                    $query->where('project_id', '=' , $project_id);
                }
                if ($contract_id) {
                    $query->where('code', '=' , $contract_id);
                }
                if ($status_id) {
                    $query->where('status_id', '=' , $status_id);
                }
            })
            ->orderBy('project_id')->paginate($perPage);
        $this->setTransformer(new ContractReportTransformer(true));
        return $this->responsePaginatedCollection($getPaymentDetails, 200);
    }

    public function getOther(Request $request){
        $getProjects = $this->projectManagementRepository->model()->orderBy('id')->get();
        $this->setTransformer(new ProjectManagementTransformer(true));
        $getContracts = $this->contractRepository->model()->orderBy('id')->get();
        $this->setTransformer(new ContractTransformer(true));
        $getSystemStatuses = $this->systemStatusRepository->model()->orderBy('id')->get();
        $this->setTransformer(new SystemStatusTransformer(true));
        return response()->json([
            'getProjects'=>$getProjects,
            'getContracts'=>$getContracts,
            'getSystemStatuses'=>$getSystemStatuses,
        ], 200);
    }
}
