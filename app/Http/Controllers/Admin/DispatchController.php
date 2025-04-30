<?php

namespace App\Http\Controllers\Admin;

use App\Biz\Newway\NotificationBiz;
use Illuminate\Http\Request;
use App\Enums\SystemPermissionEnum;
use App\Http\Controllers\Controller;
use App\Transformers\CustomerTransformer;
use App\Transformers\DispatchTransformer;
use App\Http\Requests\DispatchStoreRequest;
use App\Http\Requests\DispatchUpdateRequest;
use App\Transformers\SystemStatusTransformer;
use function App\Helper\check_user_permission;
use App\Transformers\ProjectManagementTransformer;
use App\Repositories\Interfaces\ICustomerRepository;
use App\Repositories\Interfaces\IDispatchRepository;

use App\Repositories\Interfaces\ISystemStatusRepository;
use App\Repositories\Interfaces\IProjectManagementRepository;
use App\Models\Dispatch;
use App\Models\Role;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\File;

class DispatchController extends Controller
{
    protected $dispatchRepository;
    protected $projectManagementRepository;
    protected $customerRepository;
    protected $systemStatusRepository;
    protected $notificationBiz;
    public function __construct(
        IDispatchRepository $dispatchRepository,
        IProjectManagementRepository $projectManagementRepository,
        ICustomerRepository $customerRepository,
        ISystemStatusRepository $systemStatusRepository,
        NotificationBiz $notificationBiz
        )
    {
        $this->dispatchRepository = $dispatchRepository;
        $this->projectManagementRepository = $projectManagementRepository;
        $this->customerRepository = $customerRepository;
        $this->systemStatusRepository = $systemStatusRepository;
        $this->notificationBiz = $notificationBiz;
    }

    public function index()
    {

        $breadcrumbs = [
            [
                'link' => null,
                'text' => __('Danh sách công văn, thông báo')
            ],
        ];
        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_DISPATCHES);
        $notificationId = request()->notification_id;
        if($notificationId) {
            $this->notificationBiz->updateNotificationReadAt($notificationId);
        }
        $data = [
            'pageName' =>  trans('Danh sách công văn, thông báo'),
            'breadcrumbs' => $breadcrumbs,
            'btnAdd' => $btnAdd,
            'code' => request()->code,
            'id' => request()->id
        ];
        return view('admin.dispatches.index')->with($data);
    }

    public function show($id)
    {
        $entry = $this->dispatchRepository->model()->with('project','customer','status', 'files')->find($id);
        if(!$entry) {
            return $this->errorsResponse(['message' => trans('Mã công văn, thông báo không tồn tại.')], 422);
        }
        return $this->successResponse(['data' => $entry, 200]);
    }
    public function getAllDispatches(Request $request)
    {
        $perPage = $request->per_page;
        if (!$perPage) {
            $perPage = 30;
        }

        if($request->getAll) {
            // ->select(['id', 'name', 'code'])
            return $this->successResponse(['data' => $this->dispatchRepository->model() ->with('project','customer','status', 'files')->orderBy('name')->get(), 200]);
        }

        $fromDate = $request->from_date;
        $toDate = $request->to_date;
        $project = $request->project;
        $type = $request->type;
        $sender = $request->sender;
        $receiver = $request->receiver;
        $status_id = $request->status_id;
        $getDispatches = $this->dispatchRepository->model()
            ->with('project','customer','status', 'files')
            ->where(function ($query) use (
                $fromDate,
                $toDate,
                $project,
                $type,
                $sender,
                $status_id,
                $receiver,
            ) {
                if($fromDate) {
                    $query->whereDate('date', '>=', $fromDate);
                }
                if($toDate) {
                    $query->whereDate('date', '<=', $toDate);
                }
                if ($project) {
                    $query->whereHas('project', function ($q) use ($project) {
                        $q->where('name', 'like', '%' . $project . '%')
                        ->orWhere('code', 'like', '%' . $project . '%');
                    });
                }

                if ($sender) {
                    $query->where('sender', 'like', '%' . $sender . '%');
                }
                if ($receiver) {
                    $query->where('receiver', 'like', '%' . $receiver . '%');
                }
                if ($type!=null && in_array($type, [0,1])) {
                    $query->where('type', $type);
                }
                if ($status_id) {
                    $query->where('status_id', '=' , $status_id);
                }
            })
            ->orderByDesc('project_id')->orderByDesc('id')->paginate($perPage);
        $this->setTransformer(new DispatchTransformer(true, true));
        return $this->responsePaginatedCollection($getDispatches, 200);
    }

    public function getProjectsCustomers(Request $request){
        $getProjectManagement = $this->projectManagementRepository->model()->orderBy('id')->get();
        $this->setTransformer(new ProjectManagementTransformer(true));
        $getCustomer = $this->customerRepository->model()->orderBy('id')->get();
        $this->setTransformer(new CustomerTransformer(true));
        $getSystemStatus = $this->systemStatusRepository->model()->orderBy('id')->get();
        $this->setTransformer(new SystemStatusTransformer(true));
        return response()->json([
            'getProjectManagement'=>$getProjectManagement,
            'getCustomer'=>$getCustomer,
            'getSystemStatus'=>$getSystemStatus,
        ], 200);
    }

    public function store(DispatchStoreRequest $request)
    {
        $role = Role::with('users')->find(1);
        $usersRole = $role->users->unique('id')->keyBy('id');

        $data = $request->all();
        
        if(isset($data['sender']) && $data['sender'] =="null") {
            $data['sender'] = null;
        }
        if(isset($data['receiver']) && $data['receiver'] =="null") {
            $data['receiver'] = null;
        }
        if(isset($data['content']) && $data['content'] =="null") {
            $data['content'] = null;
        }
        if(isset($data['note']) && $data['note'] =="null") {
            $data['note'] = null;
        }
        DB::beginTransaction();
        try {
            $dispatch = $this->dispatchRepository->create($data);
             if ($request->hasFile('filesArr')) {
                $files = $request->file('filesArr');
                $timestamp = date('Y-m-d_H:i:s');
                foreach ($files as $item) {
                    $filePath = $this->uploadFile($item);
                    $dispatch->files()->create([
                        'name' => $filePath,
                        'path' => 'file-dispatch/' . $timestamp . '_' . $filePath,
                        'entry_id' => $dispatch->id,
                        'entry_type' => Dispatch::class
                    ]);
                }
            }

            // Cảnh báo bắt đầu đến thời hạn công văn, thông báo (1 công văn)
            $projectOfDispatchesFromDate = $this->dispatchRepository->getDataSendNotificationsFromDate($dispatch);

            if($projectOfDispatchesFromDate) {

                $this->notificationBiz->createNotifications(
                    $usersRole->replace($projectOfDispatchesFromDate->project->functionProjectHasUsers->unique('id')->keyBy('id')),
                    $projectOfDispatchesFromDate);
            }

            // Cảnh báo hết thời hạn công văn, thông báo (1 công văn)
            $projectOfDispatchesToDate = $this->dispatchRepository->getDataSendNotificationsToDate($dispatch);

            if($projectOfDispatchesToDate) {

                $this->notificationBiz->createNotifications(
                    $usersRole->replace($projectOfDispatchesToDate->project->functionProjectHasUsers->unique('id')->keyBy('id')),
                    $projectOfDispatchesToDate);

            }

            DB::commit();
            return $this->successResponse(['dispatch' => $dispatch, 'message' => trans('Thêm thành công !')], 200);
        } catch (\Exception $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function uploadFile($file)
    {
        $filename = $file->getClientOriginalName();
        $timestamp = date('Y-m-d_H:i:s');

        $new_filename =   $timestamp . '_' . $filename;
        Storage::disk('public')->put('/file-dispatch/' . $new_filename, $file->getContent());
        return $filename;
    }

    public function update(DispatchUpdateRequest $request, $id)
    {
        $role = Role::with('users')->find(1);
        $usersRole = $role->users->unique('id')->keyBy('id');
        $data = $request->except('code');

        if(isset($data['sender']) && $data['sender'] =="null") {
            $data['sender'] = null;
        }
        if(isset($data['receiver']) && $data['receiver'] =="null") {
            $data['receiver'] = null;
        }
        if(isset($data['content']) && $data['content'] =="null") {
            $data['content'] = null;
        }
        if(isset($data['note']) && $data['note'] =="null") {
            $data['note'] = null;
        }
        $entry = $this->dispatchRepository->findWithRelationships($id, ['files']);
        if (!$entry) {
            return $this->errorsResponse(['id' => trans('Không tồn tại!')], 422);
        }
        DB::beginTransaction();
        try {
            $checkChangeFromDate = $entry->from_date;
            $checkChangeToDate = $entry->to_date;

            $dispatch = $entry->update($data);
            if ($request->hasFile('filesArr')) {
                $files = $request->file('filesArr');
                $timestamp = date('Y-m-d_H:i:s');

                foreach ($files as $item) {
                    $filePath = $this->uploadFile($item);
                    $entry->files()->create([
                        'name' => $filePath,
                        'path' => 'file-dispatch/' . $timestamp . '_' . $filePath,
                        'entry_id' => $entry->id,
                        'entry_type' => Dispatch::class
                    ]);
                }
            }

            // Lấy mảng fileDeletes từ request
            $fileDeletes = json_decode($request->input('fileDeletes'));
            // dd($fileDeletes);
            $files = File::whereIn('id', $fileDeletes)->get();

            // Duyệt qua các id của tệp ảnh cần xóa
            foreach ($files as $file) {
                $path = $file->path;
                $id = $file->id;
                // dd($id);

                // dd(Storage::disk('public')->exists('/' . $path));
                if (Storage::disk('public')->exists('/' . $path)) {
                    unlink(storage_path('app/public/' . $path));
                }
                // Tìm tệp ảnh theo id
                $deleteFile = File::find($id);
                // Xóa tệp ảnh khỏi cơ sở dữ liệu
                $deleteFile->delete();
            }

            $entry = $entry->refresh();

             // Cảnh báo bắt đầu đến thời hạn công văn, thông báo (1 công văn)
             $projectOfDispatchesFromDate = $this->dispatchRepository->getDataSendNotificationsFromDate($entry);

             if($projectOfDispatchesFromDate && $checkChangeFromDate != $entry->from_date) {

                 $this->notificationBiz->createNotifications(
                     $usersRole->replace($projectOfDispatchesFromDate->project->functionProjectHasUsers->unique('id')->keyBy('id')),
                     $projectOfDispatchesFromDate);
             }

             // Cảnh báo hết thời hạn công văn, thông báo (1 công văn)
             $projectOfDispatchesToDate = $this->dispatchRepository->getDataSendNotificationsToDate($entry);

             if($projectOfDispatchesToDate && $checkChangeToDate != $entry->to_date) {

                 $this->notificationBiz->createNotifications(
                     $usersRole->replace($projectOfDispatchesToDate->project->functionProjectHasUsers->unique('id')->keyBy('id')),
                     $projectOfDispatchesToDate);

             }
            DB::commit();
            return $this->successResponse(['dispatch' => $dispatch, 'message' => trans('Sửa thành công !')], 200);
        } catch (\Exception $th) {
             DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $entry = $this->dispatchRepository->find($id);
        if (!$entry) {
            return $this->errorsResponse(["id" => trans("Không tồn tại !")], 404);
        }
        try {
            $entry->forceDelete($id);
            return $this->successResponse(['dispatch' => $entry, 'message' => trans('Xóa dữ liệu thành công!')], 200);
        } catch (\Exception $e) {
            return $this->errorResponse(['id' => $e->getMessage()]);
        }
    }
}
