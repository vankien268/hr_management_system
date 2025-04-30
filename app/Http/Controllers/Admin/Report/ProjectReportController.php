<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\IProjectManagementRepository;
use App\Repositories\Interfaces\ICustomerRepository;
use App\Repositories\Interfaces\ISystemStatusRepository;
use App\Repositories\Interfaces\IProjectTypeRepository;
use App\Repositories\Interfaces\ICityRepository;
use App\Transformers\ProjectManagementReportTransformer;
use App\Transformers\SystemStatusTransformer;
use App\Transformers\CustomerTransformer;
use App\Transformers\ProjectTypeTransformer;
use App\Transformers\CityTransformer;
use App\Biz\Newway\Excel\ExportExcel;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

class ProjectReportController extends Controller
{
    protected $projectManagementRepository;
    protected $systemStatusRepository;
    protected $customerRepository;
    protected $projectTypeRepository;
    protected $cityRepository;
    public function __construct(
        IProjectManagementRepository $projectManagementRepository,
        ISystemStatusRepository $systemStatusRepository,
        ICustomerRepository $customerRepository,
        IProjectTypeRepository $projectTypeRepository,
        ICityRepository $cityRepository,
    )
    {
        $this->projectManagementRepository = $projectManagementRepository;
        $this->systemStatusRepository = $systemStatusRepository;
        $this->customerRepository = $customerRepository;
        $this->projectTypeRepository = $projectTypeRepository;
        $this->cityRepository = $cityRepository;
    }

    public function index()
    {
        return view('admin.reports.projects.index',
        [
            'hideHeader' => true,
        ]);
    }

    public function getAllProjects(Request $request)
    {
        $perPage = $request->per_page;
        if (!$perPage) {
            $perPage = 30;
        }

        $fromDate = $request->from_date;
        $toDate = $request->to_date;
        $customer_id = $request->customer_id;
        $project_type_id = $request->project_type_id;
        $status_id = $request->status_id;
        $city_id = $request->city_id;
        $getProjects = $this->projectManagementRepository->model()
            ->with(['customer','city','projectType','contacts','users','statusProject'])
            ->where(function ($query) use (
                $fromDate,
                $toDate,
                $customer_id,
                $status_id,
                $project_type_id,
                $city_id,
            ) {
                if($fromDate) {
                    $query->whereDate('created_at', '>=', $fromDate);
                }
                if($toDate) {
                    $query->whereDate('created_at', '<=', $toDate);
                }
                if ($customer_id) {
                    $query->where('customer_id', '=' , $customer_id);
                }
                if ($status_id) {
                    $query->where('status_id', '=' , $status_id);
                }
                if ($project_type_id) {
                    $query->where('project_type_id', '=' , $project_type_id);
                }
                if ($city_id) {
                    $query->where('city_id', '=' , $city_id);
                }
            })
            ->orderBy('customer_id')->orderBy('id');
            $getProjectsClone = clone $getProjects;
            $getProjectsClone = $getProjectsClone->get();
            $getProjects = $getProjects->paginate($perPage);

            $totalProjects = $getProjectsClone->count();
        $this->setTransformer(new ProjectManagementReportTransformer(true));
        $dataExportExcel = [
            'from_date' => $fromDate,
            'to_date' => $toDate,
            'customer_id' => $customer_id,
            'project_type_id' => $project_type_id,
            'status_id' => $status_id,
            'city_id' => $city_id,
        ];
        $urlExport = route('admin.project.exportExcel',$dataExportExcel);

        return $this->responsePaginatedCollection($getProjects, 200,[
            'totalProjects' => $totalProjects,
            'url_export' => $urlExport
        ]);

    }

    public function getOther(Request $request){
        $getCustomers = $this->customerRepository->model()->orderBy('id')->get();
        $this->setTransformer(new CustomerTransformer(true));
        $getSystemStatus = $this->systemStatusRepository->model()->orderBy('id')->get();
        $this->setTransformer(new SystemStatusTransformer(true));
        $getProjectTypes = $this->projectTypeRepository->model()->orderBy('id')->get();
        $this->setTransformer(new ProjectTypeTransformer(true));
        $getCities = $this->cityRepository->model()->orderBy('id')->get();
        $this->setTransformer(new CityTransformer(true));
        return response()->json([
            'getSystemStatus'=>$getSystemStatus,
            'getCustomers'=>$getCustomers,
            'getProjectTypes'=>$getProjectTypes,
            'getCities'=>$getCities,
        ], 200);
    }

    public function exportExcel(Request $request)
    {
        $fromDate = $request->from_date;
        $toDate = $request->to_date;
        $customer_id = $request->customer_id;
        $project_type_id = $request->project_type_id;
        $status_id = $request->status_id;
        $city_id = $request->city_id;
        $data = [
            'userIn' => auth()->user()->name,
            'dateIn' => date('d/m/Y - H:i'),
            'reportName' => 'BÁO CÁO DỰ ÁN',
            'cpnName' => 'Công ty cổ phần giải pháp công nghệ Newway',
            'cpnAddress' => '74 Hồ Đền Lừ, Hoàng Mai, Hà Nội',
            'from_date' => $fromDate,
            'to_date' => $toDate,
            'customer_id' => $customer_id,
            'project_type_id' => $project_type_id,
            'status_id' => $status_id,
            'city_id' => $city_id,
        ];
        $getExportProjects = $this->projectManagementRepository->model()
            ->with(['customer','city','projectType','contacts','users','statusProject'])
            ->where(function ($query) use (
                $fromDate,
                $toDate,
                $customer_id,
                $status_id,
                $project_type_id,
                $city_id,
            ) {
                if($fromDate) {
                    $query->whereDate('created_at', '>=', $fromDate);
                }
                if($toDate) {
                    $query->whereDate('created_at', '<=', $toDate);
                }
                if ($customer_id) {
                    $query->where('customer_id', '=' , $customer_id);
                }
                if ($status_id) {
                    $query->where('status_id', '=' , $status_id);
                }
                if ($project_type_id) {
                    $query->where('project_type_id', '=' , $project_type_id);
                }
                if ($city_id) {
                    $query->where('city_id', '=' , $city_id);
                }
            })
            ->orderBy('customer_id');
            $getProjectsClone = clone $getExportProjects;
            $getProjectsClone = $getProjectsClone->get();
            $getExportProjects = $getExportProjects->get()
            ->groupBy('customer_id')->toArray();
            $totalProjects = $getProjectsClone->count();
        $this->setTransformer(new ProjectManagementReportTransformer(true));
        $view = view('excel.report-project', [
            'data' => $data,
            'getExportProjects' => $getExportProjects,
            'totalProjects' => $totalProjects,
        ]);
        return FacadesExcel::download(new ExportExcel($view, 'reportByProject'),
        "report-by-project.xlsx");
    }
}
