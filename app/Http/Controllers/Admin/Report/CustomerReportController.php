<?php

namespace App\Http\Controllers\Admin\Report;

use App\Biz\Newway\Excel\ExportExcel;
use App\Biz\Newway\Excel\ExportExcel2;
use Excel;
use App\Enums\CustomerEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\ICustomerRepository;
use App\Repositories\Interfaces\ISystemStatusRepository;
use App\Transformers\CustomerReportTransformer;
use App\Transformers\SystemStatusTransformer;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

use function Ramsey\Uuid\v1;

class CustomerReportController extends Controller
{
    protected $customerRepository;
    protected $systemStatusRepository;
    public function __construct(ICustomerRepository $customerRepository, ISystemStatusRepository $systemStatusRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->systemStatusRepository = $systemStatusRepository;
    }

    public function index()
    {
        return view('admin.reports.customers.index',
        [
            'hideHeader' => true,
        ]);
    }

    public function getAllCustomers(Request $request)
    {
        $perPage = $request->per_page;
        if (!$perPage) {
            $perPage = 30;
        }
        $fromDate = $request->from_date;
        $toDate = $request->to_date;
        $customer_type = $request->customer_type;
        $status_id = $request->status_id;
        $getCustomers = $this->customerRepository->model()
            ->with('status')
            ->where(function ($query) use (
                $fromDate,
                $toDate,
                $customer_type,
                $status_id,
            ) {
                if($fromDate) {
                    $query->whereDate('created_at', '>=', $fromDate);
                }
                if($toDate) {
                    $query->whereDate('created_at', '<=', $toDate);
                }if ($customer_type!=null && in_array($customer_type, [CustomerEnum::CUSTOMER_NORMAL, CustomerEnum::CUSTOMER_VIP])) {
                    $query->where('customer_type', $customer_type);
                }
                if ($status_id) {
                    $query->where('status_id', '=' , $status_id);
                }
            })
            ->orderBy('id');
            $getCustomersClone = clone $getCustomers;
            $getCustomersClone = $getCustomersClone->get();
            $getCustomers =  $getCustomers->paginate($perPage);

            $totalCustomers = $getCustomersClone->count();
            $totalCustomerVip = $getCustomersClone->where('customer_type', CustomerEnum::CUSTOMER_VIP)->count();
            $totalCustomerNormal = $getCustomersClone->where('customer_type', CustomerEnum::CUSTOMER_NORMAL)->count();
        $this->setTransformer(new CustomerReportTransformer(true));
        $dataExportExcel = [
            'from_date' => $fromDate,
            'to_date' => $toDate,
            'customer_type' => $customer_type,
            'status_id' => $status_id
        ];
        $urlExport = route('admin.customer.exportExcel',$dataExportExcel);
        return $this->responsePaginatedCollection($getCustomers, 200, [
            'totalCustomerVip' => $totalCustomerVip,
            'totalCustomerNormal' => $totalCustomerNormal,
            'totalCustomers' => $totalCustomers,
            'url_export' => $urlExport
        ]);
    }

    public function getOther(Request $request){
        $getSystemStatus = $this->systemStatusRepository->model()->orderBy('id')->get();
        $this->setTransformer(new SystemStatusTransformer(true));
        return response()->json(['getSystemStatus'=>$getSystemStatus], 200);
    }

    public function exportExcel(Request $request)
    {
        $fromDate = $request->from_date;
        $toDate = $request->to_date;
        $customer_type = $request->customer_type;
        $status_id = $request->status_id;
        $data = [
            'userIn' => auth()->user()->name,
            'dateIn' => date('d/m/Y - H:i'),
            'reportName' => 'BÁO CÁO KHÁCH HÀNG',
            'cpnName' => 'Công ty cổ phần giải pháp công nghệ Newway',
            'cpnAddress' => '74 Hồ Đền Lừ, Hoàng Mai, Hà Nội',
            'from_date' => $fromDate,
            'to_date' => $toDate,
            'customer_type' => $customer_type,
            'status_id' => $status_id
        ];
        $getExportCustomers = $this->customerRepository->model()
            ->with('status')
            ->where(function ($query) use (
                $fromDate,
                $toDate,
                $customer_type,
                $status_id,
            ) {
                if($fromDate) {
                    $query->whereDate('created_at', '>=', $fromDate);
                }
                if($toDate) {
                    $query->whereDate('created_at', '<=', $toDate);
                }if ($customer_type!=null && in_array($customer_type, [CustomerEnum::CUSTOMER_NORMAL, CustomerEnum::CUSTOMER_VIP])) {
                    $query->where('customer_type', $customer_type);
                }
                if ($status_id) {
                    $query->where('status_id', '=' , $status_id);
                }
            })
            ->orderBy('id');
            $getCustomersClone = clone $getExportCustomers;
            $getCustomersClone = $getCustomersClone->get();
            $getExportCustomers =  $getExportCustomers->get();

            $totalCustomers = $getCustomersClone->count();
            $totalCustomerVip = $getCustomersClone->where('customer_type', CustomerEnum::CUSTOMER_VIP)->count();
            $totalCustomerNormal = $getCustomersClone->where('customer_type', CustomerEnum::CUSTOMER_NORMAL)->count();
        $this->setTransformer(new CustomerReportTransformer(true));
        $view = view('excel.report-customer', [
            'data' => $data,
            'getExportCustomers' => $getExportCustomers,
            'totalCustomers' => $totalCustomers,
            'totalCustomerVip' => $totalCustomerVip,
            'totalCustomerNormal' => $totalCustomerNormal,
        ]);
        return FacadesExcel::download(new ExportExcel($view, 'reportByCustomer'),
        "report-by-customer.xlsx");
    }
}
