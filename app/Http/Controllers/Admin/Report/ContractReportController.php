<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\IContractRepository;
use App\Repositories\Interfaces\IProjectManagementRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Repositories\Interfaces\IContractTypeRepository;
use App\Repositories\Interfaces\ISystemStatusRepository;
use App\Transformers\ContractReportTransformer;
use App\Transformers\ProjectManagementTransformer;
use App\Transformers\UserTransformer;
use App\Transformers\ContractTypeTransformer;
use App\Transformers\SystemStatusTransformer;
use App\Biz\Newway\Excel\ExportExcel;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

class ContractReportController extends Controller
{
    protected $contractRepository;
    protected $projectManagementRepository;
    protected $userRepository;
    protected $contractTypeRepository;
    protected $systemStatusRepository;
    public function __construct(
        IContractRepository $contractRepository,
        IProjectManagementRepository $projectManagementRepository,
        IUserRepository $userRepository,
        IContractTypeRepository $contractTypeRepository,
        ISystemStatusRepository $systemStatusRepository,
    )
    {
        $this->contractRepository = $contractRepository;
        $this->projectManagementRepository = $projectManagementRepository;
        $this->userRepository = $userRepository;
        $this->contractTypeRepository = $contractTypeRepository;
        $this->systemStatusRepository = $systemStatusRepository;
    }

    public function index()
    {
        return view('admin.reports.contracts.index',
        [
            'hideHeader' => true,
        ]);
    }

    public function getAllContracts(Request $request)
    {
        $perPage = $request->per_page;
        if (!$perPage) {
            $perPage = 30;
        }

        $fromDateSigningDate = $request->from_date_signing_date;
        $toDateSigningDate = $request->to_date_signing_date;
        $fromDateExpirationDate = $request->from_date_expiration_date;
        $toDateExpirationDate = $request->to_date_expiration_date;
        $project_id = $request->project_id;
        $user_charge_id = $request->user_charge_id;
        $contract_type_id = $request->contract_type_id;
        $status_id = $request->status_id;
        $getContracts = $this->contractRepository->model()
            ->with(['contractType','status','project','userContractor','userCharge'])
            ->where(function ($query) use (
                $fromDateSigningDate,
                $toDateSigningDate,
                $fromDateExpirationDate,
                $toDateExpirationDate,
                $project_id,
                $user_charge_id,
                $contract_type_id,
                $status_id,
            ) {
                if($fromDateSigningDate) {
                    $query->whereDate('signing_date', '>=', $fromDateSigningDate);
                }
                if($toDateSigningDate) {
                    $query->whereDate('signing_date', '<=', $toDateSigningDate);
                }
                if($fromDateExpirationDate) {
                    $query->whereDate('expiration_date', '>=', $fromDateExpirationDate);
                }
                if($toDateExpirationDate) {
                    $query->whereDate('expiration_date', '<=', $toDateExpirationDate);
                }
                if ($project_id) {
                    $query->where('project_id', '=' , $project_id);
                }
                if ($user_charge_id) {
                    $query->where('user_charge_id', '=' , $user_charge_id);
                }
                if ($contract_type_id) {
                    $query->where('contract_type_id', '=' , $contract_type_id);
                }
                if ($status_id) {
                    $query->where('status_id', '=' , $status_id);
                }
            })
            ->orderBy('project_id');
            $getContractsClone = clone $getContracts;
            $getContractsClone = $getContractsClone->get();
            $getContracts = $getContracts->paginate($perPage);
            $totalContracts = $getContractsClone->count();
        $this->setTransformer(new ContractReportTransformer(true, true));
        $dataExportExcel = [
            'from_date_signing_date' => $fromDateSigningDate,
            'to_date_signing_date' => $toDateSigningDate,
            'from_date_expiration_date' => $fromDateExpirationDate,
            'yo_date_expiration_date' => $toDateExpirationDate,
            'project_id' => $project_id,
            'user_charge_id' => $user_charge_id,
            'contract_type_id' => $contract_type_id,
            'status_id' => $status_id,
        ];
        $urlExport = route('admin.contract.exportExcel',$dataExportExcel);
        return $this->responsePaginatedCollection($getContracts, 200, [
            'totalContracts' => $totalContracts,
            'url_export' => $urlExport
        ]);
    }

    public function getOther(Request $request){
        $getProjects = $this->projectManagementRepository->model()->orderBy('id')->get();
        $this->setTransformer(new ProjectManagementTransformer(true));
        $getUserCharges = $this->userRepository->model()->orderBy('id')->get();
        $this->setTransformer(new UserTransformer(true));
        $getContractTypes = $this->contractTypeRepository->model()->orderBy('id')->get();
        $this->setTransformer(new ContractTypeTransformer(true));
        $getSystemStatus = $this->systemStatusRepository->model()->orderBy('id')->get();
        $this->setTransformer(new SystemStatusTransformer(true));
        return response()->json([
            'getProjects'=>$getProjects,
            'getUserCharges'=>$getUserCharges,
            'getContractTypes'=>$getContractTypes,
            'getSystemStatus'=>$getSystemStatus,
        ], 200);
    }

    public function exportExcel(Request $request)
    {
        $fromDateSigningDate = $request->from_date_signing_date;
        $toDateSigningDate = $request->to_date_signing_date;
        $fromDateExpirationDate = $request->from_date_expiration_date;
        $toDateExpirationDate = $request->to_date_expiration_date;
        $project_id = $request->project_id;
        $user_charge_id = $request->user_charge_id;
        $contract_type_id = $request->contract_type_id;
        $status_id = $request->status_id;
        $data = [
            'userIn' => auth()->user()->name,
            'dateIn' => date('d/m/Y - H:i'),
            'reportName' => 'BÁO CÁO HỢP ĐỒNG',
            'cpnName' => 'Công ty cổ phần giải pháp công nghệ Newway',
            'cpnAddress' => '74 Hồ Đền Lừ, Hoàng Mai, Hà Nội',
            'from_date_signing_date' => $fromDateSigningDate,
            'to_date_signing_date' => $toDateSigningDate,
            'from_date_expiration_date' => $fromDateExpirationDate,
            'yo_date_expiration_date' => $toDateExpirationDate,
            'project_id' => $project_id,
            'user_charge_id' => $user_charge_id,
            'contract_type_id' => $contract_type_id,
            'status_id' => $status_id,
        ];
        $getExportContracts = $this->contractRepository->model()
            ->with(['contractType','status','project','userContractor','userCharge','customer'])
            ->where(function ($query) use (
                $fromDateSigningDate,
                $toDateSigningDate,
                $fromDateExpirationDate,
                $toDateExpirationDate,
                $project_id,
                $user_charge_id,
                $contract_type_id,
                $status_id,
            ) {
                if($fromDateSigningDate) {
                    $query->whereDate('signing_date', '>=', $fromDateSigningDate);
                }
                if($toDateSigningDate) {
                    $query->whereDate('signing_date', '<=', $toDateSigningDate);
                }
                if($fromDateExpirationDate) {
                    $query->whereDate('expiration_date', '>=', $fromDateExpirationDate);
                }
                if($toDateExpirationDate) {
                    $query->whereDate('expiration_date', '<=', $toDateExpirationDate);
                }
                if ($project_id) {
                    $query->where('project_id', '=' , $project_id);
                }
                if ($user_charge_id) {
                    $query->where('user_charge_id', '=' , $user_charge_id);
                }
                if ($contract_type_id) {
                    $query->where('contract_type_id', '=' , $contract_type_id);
                }
                if ($status_id) {
                    $query->where('status_id', '=' , $status_id);
                }
            })
            ->orderBy('project_id');
            $getContractsClone = clone $getExportContracts;
            $getContractsClone = $getContractsClone->get();
            $getExportContracts = $getExportContracts->get()
            ->groupBy('project_id')->toArray();
            // dd($getExportContracts);
            $totalContracts = $getContractsClone->count();
        $this->setTransformer(new ContractReportTransformer(true, true));
        $view = view('excel.report-contract', [
            'data' => $data,
            'getExportContracts' => $getExportContracts,
            'totalContracts' => $totalContracts,
        ]);
        return FacadesExcel::download(new ExportExcel($view, 'reportByContract'),
        "report-by-contract.xlsx");
    }
}
