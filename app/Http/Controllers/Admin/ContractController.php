<?php

namespace App\Http\Controllers\Admin;

use App\Biz\Newway\NotificationBiz;
use App\Enums\ProjectPermissionEnum;
use App\Enums\StatusEnum;
use League\Fractal\Manager;
use Illuminate\Http\Request;
use App\Enums\StatusTypeEnum;
use App\Enums\SystemPermissionEnum;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchDataContractRequest;
use App\Http\Requests\StoreContractRequest;
use App\Http\Requests\UpdateContractRequest;
use App\Http\Requests\ContractHistoryRequest;
use App\Models\Contact;
use App\Transformers\UserTransformer;
use App\Transformers\ContractTransformer;
use App\Transformers\PaymentDetailTransformer;
use App\Transformers\CustomerTransformer;
use App\Transformers\ContractTypeTransformer;
use App\Transformers\SystemStatusTransformer;
use App\Repositories\Interfaces\IUserRepository;
use App\Transformers\ProjectManagementTransformer;
use App\Transformers\ActivityLogTransformer;
use App\Repositories\Interfaces\IContractRepository;
use App\Repositories\Interfaces\IPaymentDetailRepository;
use App\Repositories\Interfaces\ICustomerRepository;
use App\Repositories\Interfaces\IProjectTypeRepository;
use App\Repositories\Interfaces\IContractTypeRepository;
use App\Repositories\Interfaces\ISystemStatusRepository;
use App\Repositories\Interfaces\IProjectManagementRepository;
use App\Repositories\Interfaces\IActivityLogRepository;
use Hamcrest\Type\IsNumeric;
use function App\Helper\check_user_permission;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\MessageBag;

class ContractController extends Controller
{
    protected $manager;
    protected $customerRepository;
    protected $projectRepository;
    protected $userRepository;
    protected $contractRepository;
    protected $paymentDetailRepository;
    protected $contractTypeRepository;
    protected $activityLogRepository;
    protected $systemStatusRepository;
    protected $transformer;
    protected $notificationBiz;
    public function __construct(

        Manager $manager,
        IUserRepository $userRepository,
        IProjectManagementRepository $projectRepository,
        IContractRepository $contractRepository,
        IContractTypeRepository $contractTypeRepository,
        IPaymentDetailRepository $paymentDetailRepository,
        ISystemStatusRepository $systemStatusRepository,
        IActivityLogRepository $activityLogRepository,
        ICustomerRepository $customerRepository,
        NotificationBiz $notificationBiz
    ) {
        $this->contractRepository = $contractRepository;
        $this->paymentDetailRepository = $paymentDetailRepository;
        $this->projectRepository = $projectRepository;
        $this->systemStatusRepository = $systemStatusRepository;
        $this->customerRepository = $customerRepository;
        $this->contractTypeRepository = $contractTypeRepository;
        $this->activityLogRepository = $activityLogRepository;
        $this->userRepository = $userRepository;

        $this->manager = $manager;
        $transformer = new ContractTransformer(['is_delete' => true]);
        $this->transformer = $transformer;
        $this->setTransformer($transformer);
        $this->notificationBiz = $notificationBiz;
    }

    /**
     * Summary of view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function view(Request $request)
    {
        request()->merge(['type' => StatusTypeEnum::CONTRACT, 'using' => true]);
        $statuses = $this->systemStatusRepository->getData()->get();

        $canExistsPermissionAddContract = false;
        $userAdmin = $this->contractRepository->model()->userAdmin();
        if ($userAdmin) {
            $canExistsPermissionAddContract = true;
        } else {
            $getAllPermisisonProject = $this->contractRepository->model()->userPermissions();
            foreach ($getAllPermisisonProject as $permissions) {
                if (in_array(ProjectPermissionEnum::ADD_CONTRACT, $permissions)) {
                    $canExistsPermissionAddContract = true;
                }
            }
        }
        $notificationId = $request->notification_id;
        if($notificationId) {
            $this->notificationBiz->updateNotificationReadAt($notificationId);
        }
        $contractTypes = $this->contractTypeRepository->getData()->get();
        return view(
            'admin.contract.contract',
            [
                'pageName' => trans("Khai báo hợp đồng"),
                'contractTypes' => $this->responseJsonData($contractTypes, new ContractTypeTransformer()),
                'statuses' => $this->responseJsonData($statuses, new SystemStatusTransformer()),
                'canExistsPermissionAddContract' => $canExistsPermissionAddContract || check_user_permission(SystemPermissionEnum::SYSTEM_ADD_CONTRACT),
                'code' =>  $request->code
            ]
        );
    }
    /**
     * Display a listing of the resource.
     */
    public function index(SearchDataContractRequest $request)
    {
        if($request->getAll) {
            return $this->responseCollection($this->contractRepository->model()->get(), 200, [], ['paginate' => false]);
        }
        $entries = $this->contractRepository->getData()->latest('id')->paginate(request('per_page') ?? 30);
        return $this->responsePaginatedCollection($entries);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContractRequest $request)
    {
        $checkPermissionAddIntoProject = $this->contractRepository->model()->checkUserHasProjectPermission(ProjectPermissionEnum::ADD_CONTRACT, $request->project_id)
        ||  check_user_permission(SystemPermissionEnum::SYSTEM_ADD_CONTRACT);
        if(!$checkPermissionAddIntoProject) {
            return $this->errorsResponse(['project_id' => [trans('Bạn không có quyền thêm hợp đồng vào dự án này.')]], 422);
        }
        $dataStore = $this->contractRepository->formatDataStore();
        $errors = $this->checkRequiredPaymentDate(isset($dataStore['payment_details']['data']) ? $dataStore['payment_details']['data'] : []);
        if(count($errors)) {
            return $this->errorsResponse($errors, 422);
        }
        DB::beginTransaction();
        try {
            $entry = $this->contractRepository->create($dataStore);
            DB::commit();
            return $this->responseOne($entry->load(['customer', 'userContractor', 'contractType', 'status', 'project', 'annexContracts', 'contractModules', 'paymentDetails']));
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorsResponse(['id' => $th->getMessage()], 422);
        }
    }

    private function checkRequiredPaymentDate($data)
    {
        $errors = new MessageBag();
        $dataCount = count($data);

        for ($i=0; $i < $dataCount; $i++) {
            if(isset($data[$i]['actual_amount'])) {
                $actualAmount = str_replace('.', '', $data[$i]['actual_amount']);
            }

            if(
                (isset($data[$i]['actual_amount'])
             && is_numeric($actualAmount)
             )

            && @!$data[$i]['payment_date']
            ) {
                $errors->add('payment_details.data.'.$i.'.payment_date', trans('Trường này không bỏ trống.'));
            }
            //
            if(
                @!$data[$i]['actual_amount']
            && ( isset($data[$i]['payment_date']) && $data[$i]['payment_date'] )
            ) {
                $errors->add('payment_details.data.'.$i.'.actual_amount', trans('Trường này không bỏ trống.'));
            }
        }
        return $errors;
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $entry = $this->contractRepository->getData()->find($id);
        if (!$entry) {
            return $this->errorResponse(trans('Hợp đồng không tồn tại.'));
        }
        return $this->responseOne($entry);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContractRequest $request, string $id)
    {
        // $checkPermissionAddIntoProject = $this->contractRepository->model()->checkUserHasProjectPermission(ProjectPermissionEnum::EDIT_CONTRACT, $request->project_id)
        // || check_user_permission(SystemPermissionEnum::SYSTEM_EDIT_CONTRACT);
        // if(!$checkPermissionAddIntoProject) {
        //     return $this->errorsResponse(['project_id' => [trans('Bạn không có quyền thêm hợp đồng vào dự án này.')]], 422);
        // }
        $dataUpdate = $this->contractRepository->formatDataUpdate();
        $errors = $this->checkRequiredPaymentDate(isset($dataUpdate['payment_details']['data']) ? $dataUpdate['payment_details']['data'] : []);
        if(count($errors)) {
            return $this->errorsResponse($errors, 422);
        }
        DB::beginTransaction();
        try {
            $entry = $this->contractRepository->update($id, $dataUpdate);
            if (!$entry) {
                return $this->errorResponse(trans('Dữ liệu tìm kiếm không tồn tại.'));
            }
            $this->contractRepository->updateContract($entry);
            DB::commit();
            return $this->responseOne($entry->load(['customer', 'userContractor', 'contractType', 'status', 'project', 'annexContracts', 'contractModules', 'paymentDetails']));
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
        $entry = $this->contractRepository->find($id);
        if (!$entry) {
            return $this->errorsResponse(['id' => trans('Dữ liệu tìm kiếm không tồn tại.')], 404);
        }
        DB::beginTransaction();
        try {
            $delete = $this->contractRepository->destroy($id);
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

    public function showContractHistory(ContractHistoryRequest $request)
    {
        $perPage = $request->per_page;
        if (!$perPage) {
            $perPage = 30;
        }
        $code_history = $request->code_history;
        $project_history = $request->project_history;
        $from_date_history = $request->from_date_history;
        $from_hour_history = $request->from_hour_history;
        $to_date_history = $request->to_date_history;
        $to_hour_history = $request->to_hour_history;
        $contract = $request->contract;
        $editor = $request->editor;
        $info = $request->info;
        $contractHistoryId = $this->contractRepository->model()->where('code', $request->contractHistoryId)->first();
        $getActivityLogs = $this->activityLogRepository->model()
            ->with([
                'paymentDetail' => function ($q) use ($contractHistoryId,$project_history) {
                    if ($contractHistoryId) {
                        $q->whereHas('contract', function ($q) use ($contractHistoryId) {
                            $q->where('id',$contractHistoryId ? $contractHistoryId->id : null)
                            ;
                        });
                    }
                    if ($project_history) {
                        $q->whereHas('contract', function ($q) use ($project_history) {
                            $q->where('project_id', $project_history);
                            ;
                        });
                    }
                },
                'annexContract' => function ($q) use ($contractHistoryId,$project_history) {
                    if ($contractHistoryId) {
                        $q->whereHas('contract', function ($q) use ($contractHistoryId) {
                            $q->where('id',$contractHistoryId ? $contractHistoryId->id : null)
                            ;
                        });
                    }
                    if ($project_history) {
                        $q->whereHas('contract', function ($q) use ($project_history) {
                            $q->where('project_id', $project_history);
                            ;
                        });
                    }
                },
                'contractModule' => function ($q) use ($contractHistoryId,$project_history) {
                    if ($contractHistoryId) {
                        $q->whereHas('contract', function ($q) use ($contractHistoryId) {
                            $q->where('id',$contractHistoryId ? $contractHistoryId->id : null)
                            ;
                        });
                    }
                    if ($project_history) {
                        $q->whereHas('contract', function ($q) use ($project_history) {
                            $q->where('project_id', $project_history);
                            ;
                        });
                    }
                },
                'contract' => function ($q) use ($contractHistoryId, $project_history) {
                    if ($contractHistoryId) {
                        $q->where('id',$contractHistoryId ? $contractHistoryId->id : null);
                    }
                    if ($project_history) {
                        $q->where('project_id', $project_history);
                    }
                },
                'user' => function ($q) use ($editor) {
                    if ($editor) {
                        $q->where('id', '=', $editor);
                    }
                },
                'jsonNewSystemStatus',
                'jsonOldSystemStatus',
                'jsonNewCustomer',
                'jsonOldCustomer',
                'jsonNewUser',
                'jsonOldUser',
                'jsonNewProjectType',
                'jsonOldProjectType',
                'jsonNewProject',
                'jsonOldProject',
                'jsonNewUserContractor',
                'jsonOldUserContractor',
                'jsonNewUserCharge',
                'jsonOldUserCharge',
                'jsonNewContractType',
                'jsonOldContractType',
                'jsonNewContract',
                'jsonOldContract',
                'jsonNewModule',
                'jsonOldModule',
            ])
            ->where(function ($query) use (
                $code_history,
                $project_history,
                $from_date_history,
                $from_hour_history,
                $to_date_history,
                $to_hour_history,
                $contract,
                $editor,
                $info,
                $contractHistoryId
            ) {
                if ($contractHistoryId) {
                    $query
                    ->whereHas('contract', function ($q) use ($contractHistoryId) {
                        $q->where('id',$contractHistoryId ? $contractHistoryId->id : null);
                    });
                    // ->orWhereHas('annexContract', function ($q) use ($contractHistoryId) {
                    //     $q->whereHas('contract', function ($q) use ($contractHistoryId) {
                    //         $q->where('id',$contractHistoryId ? $contractHistoryId->id : null)
                    //         ;
                    //     });
                    // })
                    // ->orWhereHas('contractModule', function ($q) use ($contractHistoryId) {
                    //     $q->whereHas('contract', function ($q) use ($contractHistoryId) {
                    //         $q->where('id',$contractHistoryId ? $contractHistoryId->id : null)
                    //         ;
                    //     });
                    // })
                    // ->orWhereHas('paymentDetail', function ($q) use ($contractHistoryId) {
                    //     $q->whereHas('contract', function ($q) use ($contractHistoryId) {
                    //         $q->where('id',$contractHistoryId ? $contractHistoryId->id : null);
                    //     });
                    // });
                }
                if ($project_history) {
                    $query
                    ->whereHas('contract', function ($q) use ($project_history) {
                        $q->where('project_id', $project_history);
                    });
                    // ->orWhereHas('paymentDetail', function ($q) use ($project_history) {
                    //     $q->whereHas('contract', function ($q) use ($project_history) {
                    //         $q->where('project_id', $project_history);
                    //         ;
                    //     });
                    // })
                    // ->orWhereHas('annexContract', function ($q) use ($project_history) {
                    //     $q->whereHas('contract', function ($q) use ($project_history) {
                    //         $q->where('project_id', $project_history);
                    //         ;
                    //     });
                    // })
                    // ->orWhereHas('contractModule', function ($q) use ($project_history) {
                    //     $q->whereHas('contract', function ($q) use ($project_history) {
                    //         $q->where('project_id', $project_history);
                    //         ;
                    //     });
                    // });
                }
                if ($editor) {
                    $query->whereHas('user', function ($q) use ($editor) {
                        $q->where('id', '=', $editor);
                    });
                }
                if ($contract) {
                    $query->whereHas('contract', function ($q) use ($contract) {
                        $q->where('id', '=', $contract);
                    });
                }
                if ($from_date_history) {
                    $query
                        ->where('updated_at', '>=', $from_date_history . ' ' . $from_hour_history);
                }

                if ($to_date_history) {
                    $query
                        ->where('updated_at', '<=', $to_date_history . ' ' . $to_hour_history);
                }
                if ($info) {
                    $query->whereNotNull('properties->attributes->' . $info);
                };
            })
            ->whereIn('subject_type', [
                "App\\Models\\Contract",
                "App\\Models\\PaymentDetail",
                "App\\Models\\AnnexContract",
                "App\\Models\\ContractModule"
                 ])
            ->orderByDesc('id')->paginate($perPage);
            $user = auth()->user();
            $findContract = $this->contractRepository->model()->where('code', $code_history)->first();
            $userPermission = [];
            if($findContract) {
                $userPermission = [
                    'canPermisisonViewPaymentContract' => $findContract->checkNumerPaymentContract(
                        ProjectPermissionEnum::VIEW_DETAIL_PAYMENT_CONTRACT,
                         $findContract->project_id
                     ) || $user->id == $findContract->created_by || in_array(SystemPermissionEnum::SYSTEM_ADMIN, request('list_permissions')),
                     'permission_contract_value' => $findContract->checkPermissionContract(ProjectPermissionEnum::VIEW_PRICE_CONTRACT, $findContract->project_id)
                     || $user->id == $findContract->created_by || in_array(SystemPermissionEnum::SYSTEM_ADMIN, request('list_permissions')),
                ];
            }

        $this->setTransformer(new ActivityLogTransformer(true, ['project']));
        return $this->responsePaginatedCollection($getActivityLogs, 200, ['userPermission' => $userPermission]);
    }

    public function getOther(Request $request)
    {
        $getUsers = $this->userRepository->model()->orderBy('id')->get();
        $this->setTransformer(new UserTransformer(true));
        $getProjects = $this->projectRepository->model()->orderBy('id')->get();
        $this->setTransformer(new ProjectManagementTransformer(true));
        $getContracts = $this->contractRepository->model()->orderBy('id')->get();
        $this->setTransformer(new ContractTransformer(true));
        return response()->json([
            'getUsers' => $getUsers,
            'getProjects' => $getProjects,
            'getContracts' => $getContracts,
        ], 200);
    }
}
