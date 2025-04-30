<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\DispatchEnum;
use App\Repositories\Interfaces\IDispatchRepository;
use App\Repositories\Interfaces\IProjectManagementRepository;
use App\Transformers\DispatchReportTransformer;
use App\Transformers\ProjectManagementTransformer;
use App\Biz\Newway\Excel\ExportExcel;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;


class DispatchReportController extends Controller
{
    protected $dispatchRepository;
    protected $projectManagementRepository;
    public function __construct(
        IDispatchRepository $dispatchRepository,
        IProjectManagementRepository $projectManagementRepository,
    )
    {
        $this->dispatchRepository = $dispatchRepository;
        $this->projectManagementRepository = $projectManagementRepository;
    }

    public function index()
    {
        return view('admin.reports.dispatches.index',
        [
            'hideHeader' => true,
        ]);
    }

    public function getAllDispatches(Request $request)
    {
        $perPage = $request->per_page;
        if (!$perPage) {
            $perPage = 30;
        }

        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $effective_from_date = $request->effective_from_date;
        $effective_to_date = $request->effective_to_date;
        $project_id = $request->project_id;
        $type = $request->type;
        $receiver = $request->receiver;
        $status_id = $request->status_id;
        $sender = $request->sender;
        $getDispatches = $this->dispatchRepository->model()
            ->with(['status'])
            ->where(function ($query) use (
                $from_date,
                $to_date,
                $effective_from_date,
                $effective_to_date,
                $project_id,
                $type,
                $receiver,
                $status_id,
                $sender,
            ) {
                if($from_date) {
                    $query->whereDate('date', '>=', $from_date);
                }
                if($to_date) {
                    $query->whereDate('date', '<=', $to_date);
                }
                if($effective_from_date) {
                    $query->whereDate('from_date', '>=', $effective_from_date);
                }
                if($effective_to_date) {
                    $query->whereDate('from_date', '<=', $effective_to_date);
                }
                if ($project_id) {
                    $query->where('project_id', '=' , $project_id);
                }
                if ($status_id) {
                    $query->where('status_id', '=' , $status_id);
                }
                if ($type!=null && in_array($type, [DispatchEnum::DISPATCH_RECEIVER,DispatchEnum::DISPATCH_SENDER])) {
                    $query->where('type', $type);
                }
                if ($sender) {
                    $query->where('sender', 'like', '%' . $sender . '%');
                }
                if ($receiver) {
                    $query->where('receiver', 'like', '%' . $receiver . '%');
                }
            })
            ->orderBy('project_id');
            $getDispatchesClone = clone $getDispatches;
            $getDispatchesClone = $getDispatchesClone->get();
            $getDispatches = $getDispatches->paginate($perPage);
            $totalDispatches = $getDispatchesClone->count();
            $totalDispatchSens = $getDispatchesClone->where('type', DispatchEnum::DISPATCH_SENDER)->count();
            $totalDispatchRecs = $getDispatchesClone->where('type', DispatchEnum::DISPATCH_RECEIVER)->count();
        $this->setTransformer(new DispatchReportTransformer(true));
        $dataExportExcel = [
            'from_date' => $from_date,
            'to_date' => $to_date,
            'effective_from_date' => $effective_from_date,
            'effective_to_date' => $effective_to_date,
            'project_id' => $project_id,
            'type' => $type,
            'receiver' => $receiver,
            'status_id' => $status_id,
            'sender' => $sender,
        ];
        $urlExport = route('admin.dispatch.exportExcel',$dataExportExcel);
        return $this->responsePaginatedCollection($getDispatches, 200,[
            'totalDispatches' => $totalDispatches,
            'totalDispatchSens' => $totalDispatchSens,
            'totalDispatchRecs' => $totalDispatchRecs,
            'url_export' => $urlExport
        ]);
    }

    public function getOther(Request $request){
        $getProjects = $this->projectManagementRepository->model()->orderBy('id')->get();
        $this->setTransformer(new ProjectManagementTransformer(true));
        $getDispatches = $this->dispatchRepository->model()->orderBy('id');
        $getDispatchesClone = clone $getDispatches;
            $getSenders =  $getDispatchesClone->select('sender')->get()->toArray();
            $getReceivers =  $getDispatchesClone->select('receiver')->get()->toArray();
            $getDispatches = $getDispatches->get();
        $this->setTransformer(new ProjectManagementTransformer(true));
        return response()->json([
            'getProjects'=>$getProjects,
            'getSenders' => $getSenders,
            'getReceivers' => $getReceivers,
        ], 200);
    }

    public function exportExcel(Request $request)
    {
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $effective_from_date = $request->effective_from_date;
        $effective_to_date = $request->effective_to_date;
        $project_id = $request->project_id;
        $type = $request->type;
        $receiver = $request->receiver;
        $status_id = $request->status_id;
        $sender = $request->sender;
        $data = [
            'userIn' => auth()->user()->name,
            'dateIn' => date('d/m/Y - H:i'),
            'reportName' => 'BÁO CÁO CÔNG VĂN, THÔNG BÁO',
            'cpnName' => 'Công ty cổ phần giải pháp công nghệ Newway',
            'cpnAddress' => '74 Hồ Đền Lừ, Hoàng Mai, Hà Nội',
            'from_date' => $from_date,
            'to_date' => $to_date,
            'effective_from_date' => $effective_from_date,
            'effective_to_date' => $effective_to_date,
            'project_id' => $project_id,
            'type' => $type,
            'receiver' => $receiver,
            'status_id' => $status_id,
            'sender' => $sender,
        ];

        $getExportDispatches = $this->dispatchRepository->model()
            ->with(['status','project','customer'])
            ->where(function ($query) use (
                $from_date,
                $to_date,
                $effective_from_date,
                $effective_to_date,
                $project_id,
                $type,
                $receiver,
                $status_id,
                $sender,
            ) {
                if($from_date) {
                    $query->whereDate('date', '>=', $from_date);
                }
                if($to_date) {
                    $query->whereDate('date', '<=', $to_date);
                }
                if($effective_from_date) {
                    $query->whereDate('from_date', '>=', $effective_from_date);
                }
                if($effective_to_date) {
                    $query->whereDate('from_date', '<=', $effective_to_date);
                }
                if ($project_id) {
                    $query->where('project_id', '=' , $project_id);
                }
                if ($status_id) {
                    $query->where('status_id', '=' , $status_id);
                }
                if ($type!=null && in_array($type, [DispatchEnum::DISPATCH_RECEIVER,DispatchEnum::DISPATCH_SENDER])) {
                    $query->where('type', $type);
                }
                if ($sender) {
                    $query->where('sender', 'like', '%' . $sender . '%');
                }
                if ($receiver) {
                    $query->where('receiver', 'like', '%' . $receiver . '%');
                }
            })
            ->orderBy('project_id');
            $getDispatchesClone = clone $getExportDispatches;
            $getDispatchesClone = $getDispatchesClone->get();
            $getExportDispatches = $getExportDispatches->get()
            ->groupBy('project_id')->toArray();
            // dd($getExportDispatches);
            $totalDispatches = $getDispatchesClone->count();
            $totalDispatchSens = $getDispatchesClone->where('type', DispatchEnum::DISPATCH_SENDER)->count();
            $totalDispatchRecs = $getDispatchesClone->where('type', DispatchEnum::DISPATCH_RECEIVER)->count();
        $this->setTransformer(new DispatchReportTransformer(true));
        $view = view('excel.report-dispatch', [
            'data' => $data,
            'getExportDispatches' => $getExportDispatches,
            'totalDispatches' => $totalDispatches,
            'totalDispatchSens' => $totalDispatchSens,
            'totalDispatchRecs' => $totalDispatchRecs,
        ]);

        return FacadesExcel::download(new ExportExcel($view, 'reportByDispatch'),
        "report-by-dispatch.xlsx");
    }
}
