<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Enums\StatusTypeEnum;
use App\Enums\SystemPermissionEnum;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Requests\CustomerHistoryRequest;
use App\Transformers\BankTransformer;
use App\Transformers\CityTransformer;
use App\Transformers\WardTransformer;
use App\Transformers\CustomerTransformer;
use App\Transformers\DistrictTransformer;
use App\Transformers\SystemStatusTransformer;
use App\Transformers\ActivityLogTransformer;
use App\Transformers\UserTransformer;
use App\Repositories\Interfaces\IBankRepository;
use App\Repositories\Interfaces\ICityRepository;
use App\Repositories\Interfaces\IWardRepository;
use App\Repositories\Interfaces\ICustomerRepository;
use App\Repositories\Interfaces\IDistrictRepository;
use App\Repositories\Interfaces\ISystemStatusRepository;
use App\Repositories\Interfaces\IActivityLogRepository;
use App\Repositories\Interfaces\IUserRepository;
use function App\Helper\check_user_permission;

class CustomerController extends Controller
{
    protected $manager;
    protected $customerRepository;
    protected $systemStatusRepository;
    protected $cityRepository;
    protected $districtRepository;
    protected $wardRepository;
    protected $bankRepository;
    protected $activityLogRepository;
    protected $userRepository;
    protected $transformer;
    public function __construct(
        Manager $manager,
        ICustomerRepository $customerRepository,
        ISystemStatusRepository $systemStatusRepository,
        ICityRepository $cityRepository,
        IDistrictRepository $districtRepository,
        IWardRepository $wardRepository,
        IBankRepository $bankRepository,
        IActivityLogRepository $activityLogRepository,
        IUserRepository $userRepository,
    ) {
        $this->customerRepository = $customerRepository;
        $this->systemStatusRepository = $systemStatusRepository;
        $this->cityRepository = $cityRepository;
        $this->districtRepository = $districtRepository;
        $this->wardRepository = $wardRepository;
        $this->bankRepository = $bankRepository;
        $this->activityLogRepository = $activityLogRepository;
        $this->userRepository = $userRepository;
        $this->manager = $manager;
        $transformer = new CustomerTransformer(['is_delete' => true]);
        $this->transformer = $transformer;
        $this->setTransformer($transformer);
    }
    /**
     * Summary of view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function view()
    {
        $cities = $this->cityRepository->getData();
        $districts = $this->districtRepository->getData();
        $wards = $this->wardRepository->getData();
        request()->merge(['type' => StatusTypeEnum::CUSTOMER, 'using' => true]);
        $statuses = $this->systemStatusRepository->getData()->get();
        $banks = $this->bankRepository->model()->where('status', StatusEnum::USING)->get();
        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_CUSTOMER);
        $btnAddVIPCustomer = check_user_permission(SystemPermissionEnum::CUD_CUSTOMER_VIP);
        // $btnVVIPCustomer = check_user_permission(SystemPermissionEnum::CUD_CUSTOMER_VIP);
        $viewCustomerContact = check_user_permission(SystemPermissionEnum::VIEW_CUSTOMER_CONTACT);
        $viewCustomerPhone = check_user_permission(SystemPermissionEnum::VIEW_CUSTOMER_PHONE);
        $users = $this->userRepository->model()->get();
        return view(
            'admin.customer.customer',
            [
                'pageName' => trans("Khai báo khách hàng"),
                'cities' => $this->responseJsonData($cities, new CityTransformer()),
                'districts' => $this->responseJsonData($districts, new DistrictTransformer()),
                'wards' => $this->responseJsonData($wards, new WardTransformer()),
                'statuses' => $this->responseJsonData($statuses, new SystemStatusTransformer()),
                'banks' => $this->responseJsonData($banks, new BankTransformer()),
                'btnAdd' => $btnAdd,
                'btnAddVIP' => $btnAddVIPCustomer,
                'viewCustomerContact' => $viewCustomerContact,
                'viewCustomerPhone' => $viewCustomerPhone,
                'users' =>  $users
            ]
        );
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $entries = $this->customerRepository->getData();
        if ($request->getAll) {
            return $this->responseCollection($entries->orderBy('name')->get(), 200, [], ['paginate' => false]);
        }
        return $this->responsePaginatedCollection($entries->paginate(request('per_page') ?? 30));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $dataStore = $this->customerRepository->formatDataStore();
        DB::beginTransaction();
        try {
            $entry = $this->customerRepository->create($dataStore);
            DB::commit();
            return $this->responseOne($entry->load('status'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorsResponse(['id' => $th->getMessage()], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, string $id)
    {
        $dataUpdate = $this->customerRepository->formatDataUpdate();
        DB::beginTransaction();
        try {
            $entry = $this->customerRepository->update($id, $dataUpdate);
            if (!$entry) {
                return $this->errorResponse(trans('Dữ liệu tìm kiếm không tồn tại.'));
            }
            DB::commit();
            return $this->responseOne($entry->load('status'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorsResponse(['id' => $th->getMessage()], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $entry = $this->customerRepository->find($id);
        if (!$entry) {
            return $this->errorsResponse(['id' => trans('Dữ liệu tìm kiếm không tồn tại.')], 404);
        }
        DB::beginTransaction();
        try {
            $delete = $this->customerRepository->destroy($id);
            if ($delete === false) {
                return $this->errorsResponse(['id' => trans('Không thể xóa đo đã phát sinh dữ liệu liên quan.')], 422);
            }
            DB::commit();
            return $this->responseOne($entry);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorsResponse(['id' => $th->getMessage()], 422);
        }
    }

    public function showCustomerHistory(CustomerHistoryRequest $request)
    {
        $perPage = $request->per_page;
        if (!$perPage) {
            $perPage = 30;
        }
        $code_history = $request->code_history;
        $name_history = $request->name_history;
        $from_date_history = $request->from_date_history;
        $from_hour_history = $request->from_hour_history;
        $to_date_history = $request->to_date_history;
        $to_hour_history = $request->to_hour_history;
        $editor = $request->editor;
        $info = $request->info;
        $getActivityLogs = $this->activityLogRepository->model()
        ->forSubjects($this->customerRepository->model())
            ->with([
                'user' => function ($q) use ($editor) {
                    if ($editor) {
                        $q->where('id', '=', $editor);
                    }
                },
                'customer' => function ($q) use ($code_history, $name_history) {
                    if ($code_history) {
                        $q->where('code', 'like', '%' . $code_history . '%');
                    }
                    if ($name_history) {
                        $q->where('name', 'like', '%' . $name_history . '%');
                    }
                },
                'jsonNewCity',
                'jsonOldCity',
                'jsonNewDistrict',
                'jsonOldDistrict',
                'jsonNewWard',
                'jsonOldWard',
                'jsonNewBank',
                'jsonOldBank',
                'jsonNewSystemStatus',
                'jsonOldSystemStatus',
                'jsonNewCustomer',
                'jsonOldCustomer',
                'jsonNewUser',
                'jsonOldUser',
                'jsonNewProjectType',
                'jsonOldProjectType',
                'jsonNewUserChargeCustomer',
                'jsonOldUserChargeCustomer',
            ])
            ->where(function ($query) use (
                $code_history,
                $name_history,
                $from_date_history,
                $from_hour_history,
                $to_date_history,
                $to_hour_history,
                $editor,
                $info,
            ) {
                if ($editor) {
                    $query->whereHas('user', function ($q) use ($editor) {
                        $q->where('id', '=', $editor);
                    });
                }
                if ($code_history) {
                    $query->whereHas('customer', function ($q) use ($code_history) {
                        $q->where('code', 'like', '%' . $code_history . '%');
                    });
                }
                if ($name_history) {
                    $query->whereHas('customer', function ($q) use ($name_history) {
                        $q->where('name', 'like', '%' . $name_history . '%');
                    });
                }
                if ($from_date_history) {
                    $query
                    ->where('updated_at', '>=', $from_date_history .' '. $from_hour_history);
                }

                if ($to_date_history) {
                    $query
                    ->where('updated_at', '<=', $to_date_history .' '. $to_hour_history);
                }
                if ($info) {
                    $query->whereNotNull('properties->attributes->'.$info);
                };
            })
            ->where('subject_type', '=', "App\\Models\\Customer")->orderByDesc('id')->paginate($perPage);
        $this->setTransformer(new ActivityLogTransformer(true, ['project']));
        $appendOptions = [
            'view_representative_name' => check_user_permission(SystemPermissionEnum::VIEW_CUSTOMER_CONTACT),
            'view_representative_email_and_phone' => check_user_permission(SystemPermissionEnum::VIEW_CUSTOMER_PHONE),

         ];
        return $this->responsePaginatedCollection($getActivityLogs, 200, ['system_permission' =>  $appendOptions]);
    }

    public function getOther(Request $request)
    {
        $getUsers = $this->userRepository->model()->orderBy('id')->get();
        $this->setTransformer(new UserTransformer(true));
        return response()->json([
            'getUsers' => $getUsers,
        ], 200);
    }
}
