<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\IDeploymentRecordRepository;
use App\Repositories\Interfaces\IProjectManagementRepository;
use App\Repositories\Interfaces\ISystemStatusRepository;
use App\Repositories\Interfaces\IDeploymentScheduleRepository;
use App\Transformers\DeploymentRecordReportTransformer;
use App\Transformers\DeploymentScheduleReportTransformer;
use App\Transformers\ProjectManagementTransformer;
use App\Transformers\SystemStatusTransformer;
use App\Biz\Newway\Excel\ExportExcel;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

class DeploymentRecordReportController extends Controller
{
    protected $deploymentScheduleRepository;
    protected $projectManagementRepository;
    protected $systemStatusRepository;
    public function __construct(
        IDeploymentScheduleRepository $deploymentScheduleRepository,
        IProjectManagementRepository $projectManagementRepository,
        ISystemStatusRepository $systemStatusRepository,
        )
    {
        $this->deploymentScheduleRepository = $deploymentScheduleRepository;
        $this->projectManagementRepository = $projectManagementRepository;
        $this->systemStatusRepository = $systemStatusRepository;
    }

    public function index()
    {
        return view('admin.reports.deployment-records.index',
        [
            'hideHeader' => true,
        ]);
    }

    public function getAllDeploymentRecords(Request $request)
    {
        $perPage = $request->per_page;
        if (!$perPage) {
            $perPage = 30;
        }

        $handover_date_from_date = $request->handover_date_from_date;
        $handover_date_to_date = $request->handover_date_to_date;
        $project_id = $request->project_id;
        $status_id = $request->status_id;
        $getDeploymentRecords = $this->deploymentScheduleRepository->model()
            ->with('project','status')
            ->where(function ($query) use (
                $handover_date_from_date,
                $handover_date_to_date,
                $project_id,
                $status_id,
            ) {
                if($handover_date_from_date) {
                    $query->whereDate('from_date', '>=', $handover_date_from_date);
                }
                if($handover_date_to_date) {
                    $query->whereDate('from_date', '<=', $handover_date_to_date);
                }
                if ($project_id) {
                    $query->where('project_id', '=' , $project_id);
                }
                if ($status_id) {
                    $query->where('status_id', '=' , $status_id);
                }
            })
            ->orderByDesc('project_id')->orderBy('id')->paginate($perPage);
        $this->setTransformer(new DeploymentScheduleReportTransformer(true,true));
        $dataExportExcel = [
            'handover_date_from_date' => $handover_date_from_date,
            'handover_date_to_date' => $handover_date_to_date,
            'project_id' => $project_id,
            'status_id' => $status_id,
        ];
        $urlExport = route('admin.deployment-record.exportExcel', $dataExportExcel);
        return $this->responsePaginatedCollection($getDeploymentRecords, 200,[
            'url_export' => $urlExport
        ]);
    }

    public function getOther(Request $request){
        $getProjectManagement = $this->projectManagementRepository->model()->orderBy('id')->get();
        $this->setTransformer(new ProjectManagementTransformer(true));
        $getSystemStatus = $this->systemStatusRepository->model()->orderBy('id')->get();
        $this->setTransformer(new SystemStatusTransformer(true));
        return response()->json([
            'getProjectManagement'=>$getProjectManagement,
            'getSystemStatus'=>$getSystemStatus,
        ], 200);
    }

    public function exportExcel(Request $request)
    {
        $handover_date_from_date = $request->handover_date_from_date;
        $handover_date_to_date = $request->handover_date_to_date;
        $project_id = $request->project_id;
        $status_id = $request->status_id;
        $data = [
            'userIn' => auth()->user()->name,
            'dateIn' => date('d/m/Y - H:i'),
            'reportName' => 'BÁO CÁO TIẾN ĐỘ TRIỂN KHAI',
            'cpnName' => 'Công ty cổ phần giải pháp công nghệ Newway',
            'cpnAddress' => '74 Hồ Đền Lừ, Hoàng Mai, Hà Nội',
            'handover_date_from_date' => $handover_date_from_date,
            'handover_date_to_date' => $handover_date_to_date,
            'project_id' => $project_id,
            'status_id' => $status_id,
        ];
        $getExportDeploymentRecords = $this->deploymentScheduleRepository->model()
            ->with('project','status')
            ->where(function ($query) use (
                $handover_date_from_date,
                $handover_date_to_date,
                $project_id,
                $status_id,
            ) {
                if($handover_date_from_date) {
                    $query->whereDate('from_date', '>=', $handover_date_from_date);
                }
                if($handover_date_to_date) {
                    $query->whereDate('from_date', '<=', $handover_date_to_date);
                }
                if ($project_id) {
                    $query->where('project_id', '=' , $project_id);
                }
                if ($status_id) {
                    $query->where('status_id', '=' , $status_id);
                }
            })
            ->orderByDesc('project_id')->orderBy('id')->get()
            ->groupBy('project_id')->toArray()
            ;
        $this->setTransformer(new DeploymentScheduleReportTransformer(true,true));
        $view = view('excel.report-deployment-record', [
            'data' => $data,
            'getExportDeploymentRecords' => $getExportDeploymentRecords,
        ]);
        return FacadesExcel::download(
            new ExportExcel($view, 'reportByDeploymentRecord'),
            "report-by-deployment-record.xlsx"
        );
    }
}
