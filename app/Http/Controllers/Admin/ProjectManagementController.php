<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ProjectPermissionEnum;
use App\Enums\SystemFunctionEnum;
use App\Enums\SystemPermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionProjectStoreRequest;
use App\Http\Requests\ProjectManagementStoreRequest;
use App\Http\Requests\ProjectManagementUpdateRequest;
use App\Http\Requests\ProjectOfTaskStoreRequest;
use App\Http\Requests\ProjectOfUserDestroyRequest;
use App\Http\Requests\ProjectOfUserStoreRequest;
use App\Http\Requests\ProjectOfUserUpdateRequest;
use App\Http\Requests\SearchDataProjectRequest;
use App\Http\Requests\SearchHistoryProjectRequest;
use App\Models\ActivityLog;
use App\Models\ContactProject;
use App\Models\Project;
use App\Models\ProjectFunctionUser;
use App\Models\ProjectUser;
use App\Models\RoleSystemFunction;
use App\Models\SystemFunction;
use App\Models\Task;
use App\Models\User;
use App\Repositories\Interfaces\IActivityLogRepository;
use App\Repositories\Interfaces\IContactRepository;
use App\Repositories\Interfaces\IProjectManagementRepository;
use App\Repositories\Interfaces\ITaskRepository;
use App\Repositories\Interfaces\ICustomerRepository;
use App\Repositories\Interfaces\IProjectTypeRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Transformers\ActivityLogTransformer;
use App\Transformers\ProjectManagementTransformer;
use App\Transformers\UserTransformer;
use App\Transformers\CustomerTransformer;
use App\Transformers\ProjectTypeTransformer;
use App\Transformers\TaskTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Arr;
use Spatie\Activitylog\Models\Activity;

use function App\Helper\check_user_permission;

class ProjectManagementController extends Controller
{
    protected $projectManagementRepository;
    protected $contactRepository;
    protected $taskRepository;
    protected $activityLogRepository;
    protected $customerRepository;
    protected $projectTypeRepository;
    protected $userRepository;

    public function __construct(
        IProjectManagementRepository $projectManagementRepository,
        IContactRepository $contactRepository,
        ITaskRepository $taskRepository,
        IActivityLogRepository $activityLogRepository,
        ICustomerRepository $customerRepository,
        IProjectTypeRepository $projectTypeRepository,
        IUserRepository $userRepository
    ) {
        $this->projectManagementRepository = $projectManagementRepository;
        $this->contactRepository =  $contactRepository;
        $this->taskRepository = $taskRepository;
        $this->activityLogRepository = $activityLogRepository;
        $this->customerRepository = $customerRepository;
        $this->projectTypeRepository = $projectTypeRepository;
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $breadcrumbs = [
            [
                'link' => null,
                'text' => __('Quản lý dự án')
            ],
        ];
        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_PROJECT);
        $users = $this->userRepository->model()->get();
        $customers = $this->customerRepository->model()->get();
        $data = [
            'pageName' => trans('Quản lý dự án'),
            'breadcrumbs' => $breadcrumbs,
            'btnAdd' => $this->projectManagementRepository->model()->userAdmin(auth()->user())? true: $btnAdd,
            'users' => $users,
            'customers' => $customers
        ];
        return view('admin.projects-management.index')->with($data);
    }

    private function getProjectsOfUser()
    {
        $permissionProjects =  $this->projectManagementRepository->model()->userPermissions();
        return $permissionProjects;
    }

    private function checkProjectPermission($permission, $projectId)
    {
        return $this->projectManagementRepository->model()->checkUserHasProjectPermission($permission, $projectId);
    }

    public function getAllProjects(SearchDataProjectRequest $request)
    {
        // $user = auth()->user();

        $projects =  $this->projectManagementRepository->getProjectsALLData($request);
        $this->setTransformer(new ProjectManagementTransformer(true, true, true));

        if ($request->getAll) {
            if($request->projectPermission) {
                $permissionProjects =  $this->getProjectsOfUser();
                $uersHasPermissionAddContractIntoProjectIds = [];
                // QUyền thêm hợp đồng cho dự án ở màn dự án
                // Lấy ra các project_id mà đc phép thêm hợp đồng vào
                foreach($permissionProjects as $key => $item) {
                    if($this->checkProjectPermission(ProjectPermissionEnum::ADD_CONTRACT, $key) ||
                    $this->checkProjectPermission(ProjectPermissionEnum::EDIT_CONTRACT, $key)
                    ) {
                        $uersHasPermissionAddContractIntoProjectIds[] = $key;
                    }
                }
                // Quyền hệ thống
                $projectsAll = $projects->orderBy('name')->get();
                $isSystemPermission = false;
                if(check_user_permission(SystemPermissionEnum::SYSTEM_EDIT_CONTRACT)
                  || check_user_permission(SystemPermissionEnum::SYSTEM_ADD_CONTRACT)) {
                    $isSystemPermission = true;
                  }

                return $this->responseCollection($projectsAll, 200, ['permissionProjects' =>$isSystemPermission?
                 $projectsAll = $projectsAll->pluck('id')->toArray():  $uersHasPermissionAddContractIntoProjectIds],
                ['paginate' => false]);

            }else if($request->projectQoutePermission) {

                $permissionProjects =  $this->getProjectsOfUser();
                $uersHasPermissionAddQuoteIntoProjectIds = [];

                foreach($permissionProjects as $key => $item) {
                    if($this->checkProjectPermission(ProjectPermissionEnum::ADD_PRICE_QUOTES, $key) ||
                    $this->checkProjectPermission(ProjectPermissionEnum::EDIT_PRICE_QUOTES, $key)
                    ) {
                        $uersHasPermissionAddQuoteIntoProjectIds[] = $key;
                    }
                }
                // Quyền hệ thống
                $projectsAll = $projects->orderBy('name')->get();
                $isSystemPermission = false;
                if(check_user_permission(SystemPermissionEnum::ADD_SYSTEM_PRICE_QUOTE)
                  || check_user_permission(SystemPermissionEnum::EDIT_SYSTEM_PRICE_QUOTE)) {
                    $isSystemPermission = true;
                  }

                return $this->responseCollection($projectsAll, 200, ['permissionProjects' =>$isSystemPermission?
                 $projectsAll = $projectsAll->pluck('id')->toArray():  $uersHasPermissionAddQuoteIntoProjectIds],
                ['paginate' => false]);

            }
            return $this->responseCollection($projects->orderBy('name')->get(), 200, [], ['paginate' => false]);
        }
        $functions = SystemFunction::typeFunction(SystemFunctionEnum::TYPE_PROJECT_FUNCTION)
            ->select(['id', 'name', 'status', 'code', 'parent_id', 'related_array_id', '_lft','_rgt', 'position'])
            ->statusActive()->get()->map(function ($item) {
                $item->isParent = false;
                if (in_array($item->code, [
                    ProjectPermissionEnum::VIEW_PROJECT,
                    ProjectPermissionEnum::VIEW_CONTRACT,
                    ProjectPermissionEnum::VIEW_PRICE_QUOTES
                 ]
                 )) {
                    $item->isParent = true;
                }
                return $item;
            })->toTree()->sortBy('position')->values()->toArray();

        $searchPermissionUser = $request->searchPermissionUser;
        if($searchPermissionUser) {
            $projects = $projects->orderBy('name')->get();
        }else {
            $projects = $projects->orderByDesc('id')->paginate($request->per_page ?? 30);

        }
        $user = auth()->user();
        $projects->map(function ($item) use ($functions,  $searchPermissionUser, $user) {
            $item->functions = $functions;
            $projectFunctionUsers = $item->projectFunctions()->join('users', 'users.id', '=', 'project_function_user.user_id')
                ->select([
                    'users.name', 'users.username', 'project_function_user.user_id', 'project_function_user.project_id',
                    'project_function_user.system_function_id',
                ])->where(function ($q) use ($searchPermissionUser) {
                    if ($searchPermissionUser) {
                        $q->where('name', 'like', '%' . $searchPermissionUser . '%')
                            ->orWhere('username', 'like', '%' . $searchPermissionUser . '%');
                    }
                })->get()->groupBy('user_id')->toArray();
            $functionIds = [];
            $functionIdsOfUserLogin = [];
            foreach ($projectFunctionUsers as $key =>  $item2) {
                $ids = array_unique(array_column($item2, 'system_function_id'));
                if($user->id == $key) {
                    $functionIdsOfUserLogin[] = [
                        'functionIds' => $ids,
                        'user_id' => $key,
                        'project_id' => isset($item2[0]) ? $item2[0]['project_id'] : null,
                        'isActive' => count($ids) == ProjectPermissionEnum::TOTAL_FUNCTION_OF_PROJECT ? true : false
                    ];
                    continue;
                }
                $functionIds[] = [
                    'functionIds' => $ids,
                    'user_id' => $key,
                    'project_id' => isset($item2[0]) ? $item2[0]['project_id'] : null,
                    'isActive' => count($ids) == ProjectPermissionEnum::TOTAL_FUNCTION_OF_PROJECT ? true : false
                ];
            }
            $functionIds = array_merge($functionIdsOfUserLogin, $functionIds);
            $item->projectFunctionUsers =  $functionIds;
            return $item;
        });
        if($searchPermissionUser) {
            return $this->successResponse(['data' => $projects->toArray()], 200);
        }
        return $this->responsePaginatedCollection($projects, 200);
    }

    public function getOther(Request $request){
        $getCustomers = $this->customerRepository->model()->orderBy('id')->get();
        $this->setTransformer(new CustomerTransformer(true));
        // $getSystemStatus = $this->systemStatusRepository->model()->orderBy('id')->get();
        // $this->setTransformer(new SystemStatusTransformer(true));
        $getProjectTypes = $this->projectTypeRepository->model()->orderBy('id')->get();
        $this->setTransformer(new ProjectTypeTransformer(true));
        // $getCities = $this->cityRepository->model()->orderBy('id')->get();
        // $this->setTransformer(new CityTransformer(true));
        return response()->json([
            // 'getSystemStatus'=>$getSystemStatus,
            'getCustomers'=>$getCustomers,
            'getProjectTypes'=>$getProjectTypes,
            // 'getCities'=>$getCities,
        ], 200);
    }

    public function store(ProjectManagementStoreRequest $request)
    {
        $data = $request->all();
        if (!array_key_exists('project', $data)) {
            return $this->errorsResponse(['message' => trans('Không tồn tại thông tin dự án.')], 422);
        }
        if (!array_key_exists('contact', $data)) {
            return $this->errorsResponse(['message' => trans('Không tồn tại thông người đại diện.')], 422);
        }
        if (!array_key_exists('user', $data)) {
            return $this->errorsResponse(['message' => trans('Không tồn tại thông tin người phụ trách.')], 422);
        }
        $project = $data['project']['data'][0];
        $contact = $data['contact']['data'][0];
        $user = $data['user']['data'][0];
        $status = $contact['status'];
        DB::beginTransaction();
        try {
            # Thông tin để lưu lịch sử chỉnh sửa dự án
            $attributes = [];
            $getDataProjectHistories = $this->projectManagementRepository->getDataProjectHistoriesCreate($project, $contact, $user);
            $attributes = $getDataProjectHistories['attributes'];

            $storeProject = $this->projectManagementRepository->create($project);
            $storeProject->users()->attach($user['user_id'], ['note' => @$user['note']]);
            $contact['customer_id'] =  $project['customer_id'];
            $contact = $this->contactRepository->create($contact);
            // Thêm quyền cho người phụ trách
            $checkExists = $this->checkUserExistPermission($storeProject->id, $user['user_id']);
            if (!$checkExists && auth()->user()->id != $user['user_id']) {
                ProjectFunctionUser::create([
                    'project_id' => $storeProject->id,
                    'user_id' => $user['user_id'],
                    'system_function_id' => ProjectPermissionEnum::VIEW_PROJECT_ID
                ]);
            }
            // Thêm full quyền cho người tạo dự án
            $userIdLogin = auth()->user()->id;
            $setFullPermissionForUserCreate = [];
            $getAllProjectPermisionIds = SystemFunction::typeFunction(SystemFunctionEnum::TYPE_PROJECT_FUNCTION)
                ->statusActive()->get()->pluck('id')->toArray();
            foreach ($getAllProjectPermisionIds as $id) {
                if (in_array($id, [ProjectPermissionEnum::PROJECT_INFO_ID,
                ProjectPermissionEnum::CONTRACT_INFO_ID,
                ProjectPermissionEnum::QOUTES_PRICE_INFO_ID
                ])) {
                    continue;
                }
                $setFullPermissionForUserCreate[] = [
                    'project_id' => $storeProject->id,
                    'user_id' =>  $userIdLogin,
                    'system_function_id' => $id
                ];
            }
              # Lưu lịch sử chỉnh sửa dự án
              activity()
                  ->performedOn($storeProject) // chỉ định model chính là Project
                  ->causedBy(auth()->user()) // chỉ định người dùng gây ra hoạt động
                  ->withProperties([
                      "old" => [],
                      "attributes" => $attributes
                  ])
                  ->event('created')
                  ->log('created'); // lưu lại mô tả hoạt động

            ProjectFunctionUser::insert($setFullPermissionForUserCreate);
            $contact->projects()->attach($storeProject->id, ['note' => @$contact['note'], 'status' => $status, 'position' => 1]);
            DB::commit();
            return $this->successResponse(['message' => trans('Thêm dự án thành công !')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    private function checkUserExistPermission($projectId, $userId)
    {
        return ProjectFunctionUser::where('project_id', $projectId)->where('user_id', $userId)->first();
    }

    public function update(ProjectManagementUpdateRequest $request, $id)
    {
        $project = $this->projectManagementRepository->find($id);
        if (!$project) {
            return $this->errorsResponse(['message' => trans('Không tồn tại dự án.')], 422);
        }
        $data = $request->except('created_at');
        if (!array_key_exists('project', $data)) {
            return $this->errorsResponse(['message' => trans('Không tồn tại thông tin dự án.')], 422);
        }
        if (!array_key_exists('contact', $data)) {
            return $this->errorsResponse(['message' => trans('Không tồn tại thông người đại diện.')], 422);
        }
        if (!array_key_exists('user', $data)) {
            return $this->errorsResponse(['message' => trans('Không tồn tại thông tin người phụ trách.')], 422);
        }

        $projectRequest = $data['project']['data'][0];
        unset($projectRequest['code']);

        $contactRequest = $data['contact']['data'][0];
        $status = $contactRequest['status'];

        $user = $data['user']['data'][0];
        $noteForContactProject = null;

        if (array_key_exists('note', $contactRequest)) {
            $noteForContactProject = $contactRequest['note'];
            unset($contactRequest['note']);
        }
        $contactId = $contactRequest['contact_id'];
        unset($contactRequest['contact_id']);
        DB::beginTransaction();
        try {
            $projectOriginal =  $project->getOriginal();
            $project->update($projectRequest);
            $projectChanges =  $project->getChanges();
            $userProject = $project->users()->where('user_id', $user['old_user_id'])->first()->pivot;

            $project->users()->where('user_id', $user['old_user_id'])
                ->update(['note' => @$user['note'], 'user_id' => $user['user_id']]);
            // $project->users()->updateExistingPivot($user['user_id'], ['note' => @$user['note'], 'user_id' => $user['user_id']]);
            // Sửa quyền người phụ trách
            $checkDeleteExists = $this->checkUserExistPermission($project->id, $user['old_user_id']);
            $userLogin =  auth()->user();
            if ($checkDeleteExists && $userLogin->id != $user['old_user_id']) {
                $checkDeleteExists->delete();
            }

            if (!$this->checkUserExistPermission($project->id, $user['user_id']) && $userLogin->id != $user['user_id']) {
                ProjectFunctionUser::create([
                    'project_id' => $project->id,
                    'user_id' => $user['user_id'],
                    'system_function_id' => ProjectPermissionEnum::VIEW_PROJECT_ID
                ]);
            }
            $contact = $this->contactRepository->find($contactId);
            $contactOld =  $contact->getOriginal();
            $contact->update($contactRequest);
               //lấy các thuộc tính đã được thay đổi và giá trị mới của chúng
            $contactChanges = $contact->getChanges();
            # Thông tin để lưu lịch sử chỉnh sửa dự án
            $old = [];
            $attributes = [];

            if($projectChanges) {
                $projectOriginalNew = array_intersect_key($projectOriginal, $projectChanges);
                $getDataProjectHistories = $this->projectManagementRepository->getDataProjectHistories($projectOriginalNew, $projectChanges);
                $old = $getDataProjectHistories['old'];
                $attributes = $getDataProjectHistories['attributes'];

            }

            if($contactChanges) {
                $attributes['contact'] = $contactChanges;
                $contactOriginalNew = array_intersect_key($contactOld, $contactChanges);
                $old['contact'] = $contactOriginalNew;
            }

            $contactProjectOld = $contact->projects->first()->pivot->getOriginal();
            if(array_key_exists('status',$contactProjectOld) && $contactProjectOld['status'] != $status) {
                $old['contact']['status'] = $contactProjectOld['status'];
                $attributes['contact']['status'] = $status;
            }

            if(array_key_exists('note',$contactProjectOld) && $contactProjectOld['note'] != $noteForContactProject) {
                $old['contact']['contact_note'] = $contactProjectOld['note'];
                $attributes['contact']['contact_note'] = $noteForContactProject;
            }

            if($user['old_user_id'] != $user['user_id']) {
                $attributes['user'] = ['user_id' => $user['user_id']];
                $old['user'] = ['user_id' => $user['old_user_id']];
            }

            if($userProject->note != $user['note']) {
                $attributes['user']['user_note'] = $user['note'];
                $old['user']['user_note'] = $userProject->note;
            }
            if($old) {
                activity()
                ->performedOn($project) // chỉ định model chính là Project
                ->causedBy(auth()->user()) // chỉ định người dùng gây ra hoạt động
                ->withProperties([
                    "old" => $old,
                    "attributes" => $attributes
                ])
                ->event('updated')
                ->log('updated'); // lưu lại mô tả hoạt động
            }

            // activity()->performedOn($project)->withProperties(['name' => $contact->name, 'email' => $contact->email, 'phone' => $contact->phone, 'position' => $contact->position])->log('updated');
            $contact->projects()->updateExistingPivot($project->id, ['note' =>  $noteForContactProject, 'status' => $status]);
            DB::commit();
            return $this->successResponse(['message' => trans('Sửa dự án thành công !')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy($id)
    {
        $project = $this->projectManagementRepository->find($id);
        if (!$project) {
            return $this->errorsResponse(['message' => trans('Không tồn tại dự án.')], 422);
        }
        DB::beginTransaction();
        try {
            ProjectUser::where('project_id', $project->id)->forceDelete();
            ContactProject::where('project_id', $project->id)->forceDelete();
            $project->projectFunctionUsers()->detach();
            $project->tasks()->forceDelete();
            $project->forceDelete();
            DB::commit();
            return $this->successResponse(['message' => trans('Xóa dự án thành công !')], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }
    // thêm người đại diện phía công ty trong dự án
    public function storeUserByProject(ProjectOfUserStoreRequest $request)
    {
        $data = $request->all();
        $project = $this->projectManagementRepository->findWithRelationships($data['project_id'], ['users']);
        if ($request->get('destroyUserIds')) {
            $checkUser =  $project->users->pluck('pivot.user_id');
            if (!$checkUser->diff($request->get('destroyUserIds'))->count()) {
                return $this->successResponse(['message' => trans('Người đại diện công ty phải tồn tại ít nhất một người. Vui lòng thử lại.')], 403,);
            }
            // Xóa tất cả quyền khi user bị xóa khỏi người phụ trách dự án
            ProjectFunctionUser::where('project_id', $project->id)->whereIn('user_id', $request->get('destroyUserIds'))->delete();
            $project->users()->detach($request->get('destroyUserIds'));
        }
        $attributes = [];
        $userIds = [];
        foreach ($data['users'] as $item) {
            $attributes[$item['id']] = [
                'note' => $item['pivot']['note']
            ];
            $userIds[] = $item['id'];
        }
        DB::beginTransaction();
        try {
            // Thêm quyền cho người đại diện

            // Mặc định đã tồn tại thì sẽ có quyền xem dự án nên bỏ where('system_function_id', ProjectPermissionEnum::VIEW_PROJECT_ID)
            $users = ProjectFunctionUser::where('project_id', $project->id)
                ->whereIn('user_id',  $userIds)
                ->get()->keyBy('user_id');
            $permissionUsers = [];
            foreach ($userIds as $userId) {
                if (!isset($users[$userId])) {
                    $permissionUsers = [
                        'project_id' => $project->id,
                        'user_id' => $userId,
                        'system_function_id' => ProjectPermissionEnum::VIEW_PROJECT_ID
                    ];
                }
            }
            ProjectFunctionUser::insert($permissionUsers);
            $project->users()->sync($attributes);
            $users = $this->transformData($project->refresh()->users, new UserTransformer(true, false, true));
            DB::commit();
            return $this->successResponse(['users' => $users, 'message' => trans('Cập nhật người đại diện thành công !')], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    // Thêm nhật ký dự án
    public function storeTaskByProject(ProjectOfTaskStoreRequest $request)
    {
        $data = $request->all();
        $projectId = $data['project_id'];
        $taskMaxId = $this->taskRepository->model()->withTrashed()->max('id');
        $tasks = [];
        if ($request->get('destroyTaskIds')) {
            $this->taskRepository->destroy($request->get('destroyTaskIds'));
        }
        DB::beginTransaction();
        try {
            foreach ($data['tasks'] as $item) {
                $task = [
                    'project_id' => $projectId,
                    'date' => Carbon::createFromFormat('Y-m-d', $item['date'])->format('Y-m-d'),
                    'user_id' => $item['user_id'],
                    'note' => $item['note'],
                    'description' => $item['description'],
                    'status_id' => $item['status_id'],
                    'created_at' => now('Asia/Ho_Chi_Minh'),
                    'updated_at' => now('Asia/Ho_Chi_Minh')
                ];
                if ($item['id'] == 0) {
                    $task['id'] = ++$taskMaxId;
                    $tasks[]  = $task;
                } else {
                    $this->taskRepository->update($item['id'], $task);
                }
            }
            Task::insert($tasks);
            DB::commit();
            $project = $this->projectManagementRepository->findWithRelationships($projectId, ['tasks', 'tasks.user']);
            $project->tasks = $this->transformData( $project->tasks, new TaskTransformer(true));
            return $this->successResponse(['tasks' => $project->tasks, 'message' => trans('Cập nhật thành công !')], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }
    // phân quyền dự án
    public function storePermissionProject(PermissionProjectStoreRequest $request)
    {
        $requestAll = $request->all();

        $data =  $requestAll['permissions'];
        $errors = $this->getErrorUserDuplicate($data);
        if (count($errors)) {
            return $this->errorsResponse($errors, 422);
        }
        // $userIdDeletes =  $requestAll['destroyUserId'];
        DB::beginTransaction();
        try {
            $userIds = [];
            $projectId = $requestAll['project_id'];
            $project = $this->projectManagementRepository->findWithRelationships($projectId, ['projectFunctions']);
            $attributes = [];
            foreach ($data as $rows) {
                if (!$rows['function_ids']) {
                    return $this->errorsResponse(['message' => trans('Người dùng phải phải có ít nhất 1 chức năng.')], 400);
                }
                foreach (array_unique($rows['function_ids']) as $item) {
                    if (in_array($item, [    ProjectPermissionEnum::PROJECT_INFO_ID,
                    ProjectPermissionEnum::CONTRACT_INFO_ID,
                    ProjectPermissionEnum::QOUTES_PRICE_INFO_ID
                     ])) {
                        continue;
                    }
                    $userIds[] = $rows['user_id'];
                    $attributes[] = [
                        'user_id' =>  $rows['user_id'],
                        'project_id' => $rows['project_id'],
                        'system_function_id' => $item
                    ];
                }
            }
            $project->projectFunctionUsers()->detach();
            ProjectFunctionUser::insert($attributes);
            //    if($userIdDeletes) {
            //       ProjectFunctionUser::where('project_id',  $projectId)->whereIn('user_id', $userIdDeletes)->delete();
            //    }
            DB::commit();
            $project = $project->refresh();
            $projectFunctionUsers = $project->projectFunctions()->join('users', 'users.id', '=', 'project_function_user.user_id')
                ->select([
                    'users.name', 'users.username', 'project_function_user.user_id', 'project_function_user.project_id',
                    'project_function_user.system_function_id'
                ])->get()->unique('system_function_id')->groupBy('user_id')->toArray();

            $functionIds = [];
            foreach ($projectFunctionUsers as $key =>  $item2) {
                $ids = array_column($item2, 'system_function_id');
                $functionIds[] = [
                    'functionIds' => $ids,
                    'user_id' => $key,
                    'project_id' => isset($item2[0]) ? $item2[0]['project_id'] : null,
                    'isActive' => count($ids) == 9 ? true : false
                ];
            }
            // Xem menu dự án
            // $roles->roleSystemFunctions()->create(['system_function_id' => $i]);
            $this->setTransformer(new ProjectManagementTransformer(true, true));
            $project->projectFunctionUsers =  $functionIds;
            return $this->successResponse(['project' => $project, 'message' => trans('Cập nhật phân quyền thành công !')], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function getErrorUserDuplicate($data)
    {
        $errors = new MessageBag();
        $length = count($data);
        for ($i = 0; $i <  $length; $i++) {
            for ($j = $i + 1; $j <  $length; $j++) {
                if ($data[$i]['user_id'] == $data[$j]['user_id']) {
                    $errors->add('permissions.' . $j . '.user_id', trans('Người dùng này đã bị trùng.'));
                }
            }
        }
        return $errors;
    }

    // Lịch sử chỉnh sửa dự án
    public function historyUpdateProject(SearchHistoryProjectRequest $request, $id)
    {
        $project = $this->projectManagementRepository->findWithRelationships($id, ['contacts']);
        if (!$project) {
            return $this->errorsResponse(['message' => trans('Không tồn tại dự án.')], 422);
        }
        $perPage = $request->per_page;
        if (!$perPage) {
            $perPage = 30;
        }
        $fromHours = $request->from_hours;
        $toHours = $request->to_hours;

        $fromDate = $request->from_date;
        $toDateHasHours = null;
        $fromDateHasHours = null;
        if($fromHours) {
             $fromDateHasHours = $request->from_date." ".$fromHours.":00";
        }

        $toDate = $request->to_date;
        if($toHours) {
            $toDateHasHours = $request->to_date." ".$toHours.":59";
        }

        $editor = $request->editor;
        $searchInfo = $request->searchInfo;
        // Lấy danh sách lịch sử chỉnh sửa
        $getActivityLogs = $this->activityLogRepository->model()
        ->forSubjects($this->projectManagementRepository->model())
            ->with([
            'user',
            'customer',
            'project',
            'jsonNewCity',
            'jsonOldCity',
            'jsonNewSystemStatus',
            'jsonOldSystemStatus',
            'jsonNewCustomer',
            'jsonOldCustomer',
            'jsonNewUserWithHistoryProject',
            'jsonOldUserWithHistoryProject',
            'jsonNewProjectType',
            'jsonOldProjectType'
            ])
            ->where(function ($query) use (
                $fromDate,
                $editor,
                $toDate,
                $searchInfo,
                $toDateHasHours,
                $fromDateHasHours
            ) {
                if($editor) {
                    $query->forCausers(new User())->where('causer_id', '=', $editor);
                }
                if($fromDate && $toDate) {

                    $query->where('updated_at', '>=',$fromDateHasHours? $fromDateHasHours: $fromDate." 00:00:00")
                            ->where('updated_at', '<=', $toDateHasHours? $toDateHasHours:  $toDate." 23:59:59");

                }
                if ($searchInfo) {
                    $query->whereNotNull('properties->attributes->project->' . $searchInfo)
                           ->orWhereNotNull('properties->attributes->' . $searchInfo)
                           ->orWhereNotNull('properties->attributes->' . $searchInfo)
                           ->orWhereNotNull('properties->attributes->' . $searchInfo)
                           ->orWhereNotNull('properties->attributes->' . $searchInfo)
                           ->orWhereNotNull('properties->attributes->contact->' . $searchInfo)
                           ->orWhereNotNull('properties->attributes->user->' . $searchInfo);
                };
            })->where('subject_id', $id)
          ->orderByDesc('id')->paginate($perPage);

         $userEditors = User::join('activity_log', 'activity_log.causer_id', '=', 'users.id')
         ->where('activity_log.subject_type', '=', Project::class)
         ->select(['users.id', 'users.name', 'users.username'])
         ->get()->unique('id');

         $contactPositionFirst = $project->contacts->where('pivot.position', 1)->first();

         $appendOptions = [
            'userEditors' => $userEditors,
            'userPermissions'=> [
                'email' => $contactPositionFirst->checkUserHasProjectPermission(
                    ProjectPermissionEnum::VIEW_EMAIL_CUSTOMER_CONTACT,
                    $project->id) || check_user_permission(SystemPermissionEnum::SYSTEM_EDIT_PROJECT),
                'phone' => $contactPositionFirst->checkUserHasProjectPermission(
                    ProjectPermissionEnum::VIEW_PHONE_CUSTOMER_CONTACT,
                    $project->id) || check_user_permission(SystemPermissionEnum::SYSTEM_EDIT_PROJECT)
            ]
         ];
        $this->setTransformer(new ActivityLogTransformer(true, ['project']));
        return $this->responsePaginatedCollection($getActivityLogs, 200, $appendOptions);
    }
}
