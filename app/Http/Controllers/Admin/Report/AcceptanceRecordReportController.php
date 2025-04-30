<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\IAcceptanceRecordRepository;
use App\Repositories\Interfaces\IProjectManagementRepository;
use App\Repositories\Interfaces\ISystemStatusRepository;
use App\Transformers\AcceptanceRecordReportTransformer;
use App\Transformers\ProjectManagementTransformer;
use App\Transformers\SystemStatusTransformer;
use App\Biz\Newway\Excel\ExportExcel;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

class AcceptanceRecordReportController extends Controller
{
    protected $acceptanceRecordRepository;
    protected $projectManagementRepository;
    protected $systemStatusRepository;
    public function __construct(
        IAcceptanceRecordRepository $acceptanceRecordRepository,
        IProjectManagementRepository $projectManagementRepository,
        ISystemStatusRepository $systemStatusRepository,
    ) {
        $this->acceptanceRecordRepository = $acceptanceRecordRepository;
        $this->projectManagementRepository = $projectManagementRepository;
        $this->systemStatusRepository = $systemStatusRepository;
    }

    public function index()
    {
        return view(
            'admin.reports.acceptance-records.index',
            [
                'hideHeader' => true,
            ]
        );
    }

    public function getAllAcceptanceRecords(Request $request)
    {
        $perPage = $request->per_page;
        if (!$perPage) {
            $perPage = 30;
        }

        $acceptance_date_from_date = $request->acceptance_date_from_date;
        $acceptance_date_to_date = $request->acceptance_date_to_date;
        $sent_date_from_date = $request->sent_date_from_date;
        $sent_date_to_date = $request->sent_date_to_date;
        $project_id = $request->project_id;
        $sender = $request->sender;
        $receiver = $request->receiver;
        $status_id = $request->status_id;
        $warranty_period = $request->warranty_period;
        $getAcceptanceRecords = $this->acceptanceRecordRepository->model()
            ->with('project')
            ->where(function ($query) use (
                $acceptance_date_from_date,
                $acceptance_date_to_date,
                $sent_date_from_date,
                $sent_date_to_date,
                $project_id,
                $sender,
                $receiver,
                $status_id,
                $warranty_period,
            ) {
                if ($acceptance_date_from_date) {
                    $query->whereDate('acceptance_date', '>=', $acceptance_date_from_date);
                }
                if ($acceptance_date_to_date) {
                    $query->whereDate('acceptance_date', '<=', $acceptance_date_to_date);
                }
                if ($sent_date_from_date) {
                    $query->whereDate('sent_date', '>=', $sent_date_from_date);
                }
                if ($sent_date_to_date) {
                    $query->whereDate('sent_date', '<=', $sent_date_to_date);
                }
                if ($project_id) {
                    $query->where('project_id', '=', $project_id);
                }
                if ($sender) {
                    $query->where('sender', 'like', '%' . $sender . '%');
                }
                if ($receiver) {
                    $query->where('receiver', 'like', '%' . $receiver . '%');
                }
                if ($status_id) {
                    $query->where('status_id', '=', $status_id);
                }
                if ($warranty_period) {
                    $query->where('warranty_period', 'like', '%' . $warranty_period . '%');
                }
            })
            ->orderByDesc('project_id')->orderBy('id')->paginate($perPage);
        $this->setTransformer(new AcceptanceRecordReportTransformer(true, true));
        $dataExportExcel = [
            'acceptance_date_from_date' => $acceptance_date_from_date,
            'acceptance_date_to_date' => $acceptance_date_to_date,
            'sent_date_from_date' => $sent_date_from_date,
            'sent_date_to_date' => $sent_date_to_date,
            'project_id' => $project_id,
            'sender' => $sender,
            'receiver' => $receiver,
            'status_id' => $status_id,
            'warranty_period' => $warranty_period,
        ];
        $urlExport = route('admin.acceptance-record.exportExcel', $dataExportExcel);
        return $this->responsePaginatedCollection($getAcceptanceRecords, 200, [
            'url_export' => $urlExport
        ]);
    }

    public function getOther(Request $request)
    {
        $getProjectManagement = $this->projectManagementRepository->model()->orderBy('id')->get();
        $this->setTransformer(new ProjectManagementTransformer(true));
        $getSystemStatus = $this->systemStatusRepository->model()->orderBy('id')->get();
        $this->setTransformer(new SystemStatusTransformer(true));
        $getAcceptanceRecords = $this->acceptanceRecordRepository->model()->orderByDesc('project_id')->orderBy('id');
        $getAcceptanceRecordsClone = clone $getAcceptanceRecords;
        $getSenders =  $getAcceptanceRecordsClone->select('sender')->get()->toArray();
        $getReceivers =  $getAcceptanceRecordsClone->select('receiver')->get()->toArray();
        $getAcceptanceRecords = $getAcceptanceRecords->get();
        $this->setTransformer(new AcceptanceRecordReportTransformer(true));
        return response()->json([
            'getProjectManagement' => $getProjectManagement,
            'getSystemStatus' => $getSystemStatus,
            'getSenders' => $getSenders,
            'getReceivers' => $getReceivers,
        ], 200);
    }

    public function exportExcel(Request $request)
    {
        $acceptance_date_from_date = $request->acceptance_date_from_date;
        $acceptance_date_to_date = $request->acceptance_date_to_date;
        $sent_date_from_date = $request->sent_date_from_date;
        $sent_date_to_date = $request->sent_date_to_date;
        $project_id = $request->project_id;
        $sender = $request->sender;
        $receiver = $request->receiver;
        $status_id = $request->status_id;
        $warranty_period = $request->warranty_period;
        $data = [
            'userIn' => auth()->user()->name,
            'dateIn' => date('d/m/Y - H:i'),
            'reportName' => 'BÁO CÁO TIẾN ĐỘ NGHIỆM THU',
            'cpnName' => 'Công ty cổ phần giải pháp công nghệ Newway',
            'cpnAddress' => '74 Hồ Đền Lừ, Hoàng Mai, Hà Nội',
            'acceptance_date_from_date' => $acceptance_date_from_date,
            'acceptance_date_to_date' => $acceptance_date_to_date,
            'sent_date_from_date' => $sent_date_from_date,
            'sent_date_to_date' => $sent_date_to_date,
            'project_id' => $project_id,
            'sender' => $sender,
            'receiver' => $receiver,
            'status_id' => $status_id,
            'warranty_period' => $warranty_period,
        ];
        $getExportAcceptanceRecords = $this->acceptanceRecordRepository->model()
            ->with('project','status')
            ->where(function ($query) use (
                $acceptance_date_from_date,
                $acceptance_date_to_date,
                $sent_date_from_date,
                $sent_date_to_date,
                $project_id,
                $sender,
                $receiver,
                $status_id,
                $warranty_period,
            ) {
                if ($acceptance_date_from_date) {
                    $query->whereDate('acceptance_date', '>=', $acceptance_date_from_date);
                }
                if ($acceptance_date_to_date) {
                    $query->whereDate('acceptance_date', '<=', $acceptance_date_to_date);
                }
                if ($sent_date_from_date) {
                    $query->whereDate('sent_date', '>=', $sent_date_from_date);
                }
                if ($sent_date_to_date) {
                    $query->whereDate('sent_date', '<=', $sent_date_to_date);
                }
                if ($project_id) {
                    $query->where('project_id', '=', $project_id);
                }
                if ($sender) {
                    $query->where('sender', 'like', '%' . $sender . '%');
                }
                if ($receiver) {
                    $query->where('receiver', 'like', '%' . $receiver . '%');
                }
                if ($status_id) {
                    $query->where('status_id', '=', $status_id);
                }
                if ($warranty_period) {
                    $query->where('warranty_period', 'like', '%' . $warranty_period . '%');
                }
            })
            ->orderByDesc('project_id')->orderBy('id')->get()
            ->groupBy('project_id')->toArray();
            // dd($getExportAcceptanceRecords);
        $this->setTransformer(new AcceptanceRecordReportTransformer(true, true));
        $view = view('excel.report-acceptance-record', [
            'data' => $data,
            'getExportAcceptanceRecords' => $getExportAcceptanceRecords,
        ]);
        return FacadesExcel::download(
            new ExportExcel($view, 'reportByAcceptanceRecord'),
            "report-by-acceptance-record.xlsx"
        );
    }
}
