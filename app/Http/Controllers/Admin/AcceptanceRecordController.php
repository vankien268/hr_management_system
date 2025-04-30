<?php

namespace App\Http\Controllers\Admin;

use App\Biz\Newway\NotificationBiz;
use App\Enums\SystemPermissionEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\IAcceptanceRecordRepository;
use App\Repositories\Interfaces\IProjectManagementRepository;
use App\Repositories\Interfaces\ISystemStatusRepository;
use App\Transformers\AcceptanceRecordTransformer;
use App\Transformers\ProjectManagementTransformer;
use App\Transformers\SystemStatusTransformer;
use App\Http\Requests\AcceptanceRecordStoreRequest;
use App\Http\Requests\AcceptanceRecordUpdateRequest;
use App\Models\AcceptanceRecord;
use App\Models\Contract;
use App\Models\Dispatch;
use App\Models\Notification;
use App\Models\PaymentDetail;
use App\Models\Project;
use App\Models\Role;
use App\Notifications\SendNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification as FacadesNotification;
use App\Models\File;

use function App\Helper\check_user_permission;

class AcceptanceRecordController extends Controller
{
    protected $acceptanceRecordRepository;
    protected $projectManagementRepository;
    protected $systemStatusRepository;
    protected $notificationBiz;
    public function __construct(
        IAcceptanceRecordRepository $acceptanceRecordRepository,
        IProjectManagementRepository $projectManagementRepository,
        ISystemStatusRepository $systemStatusRepository,
        NotificationBiz $notificationBiz
        )
    {
        $this->acceptanceRecordRepository = $acceptanceRecordRepository;
        $this->projectManagementRepository = $projectManagementRepository;
        $this->systemStatusRepository = $systemStatusRepository;
        $this->notificationBiz = $notificationBiz;
    }

    public function index()
    {
        $breadcrumbs = [
            [
                'link' => null,
                'text' => __('Danh sách biên bản nghiệm thu')
            ],
        ];
        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_ACCEPTANCE_RECORD);

        $data = [
            'pageName' =>  trans('Danh sách biên bản nghiệm thu'),
            'breadcrumbs' => $breadcrumbs,
            'btnAdd' => $btnAdd,
            'id' => request()->id
        ];
        return view('admin.acceptance-records.index')->with($data);
    }

    public function getAllAcceptanceRecords(Request $request)
    {
        if($request->getAll) {
            return $this->successResponse(['data' => $this->acceptanceRecordRepository->model()->select(['id', 'title', 'code'])->orderBy('title')->get(), 200]);
        }

        $perPage = $request->per_page;
        if (!$perPage) {
            $perPage = 30;
        }

        $fromDate = $request->from_date;
        $toDate = $request->to_date;
        $project = $request->project;
        $sender = $request->sender;
        $receiver = $request->receiver;
        $status_id = $request->status_id;
        $getAcceptanceRecords = $this->acceptanceRecordRepository->model()
            ->with('project', 'files')
            ->where(function ($query) use (
                $fromDate,
                $toDate,
                $project,
                $sender,
                $receiver,
                $status_id,
            ) {
                if($fromDate) {
                    $query->whereDate('sent_date', '>=', $fromDate);
                }
                if($toDate) {
                    $query->whereDate('sent_date', '<=', $toDate);
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
                if ($status_id) {
                    $query->where('status_id', '=' , $status_id);
                }
            })
            ->orderByDesc('project_id')->orderByDesc('id')->paginate($perPage);
        $this->setTransformer(new AcceptanceRecordTransformer(true, true));
        return $this->responsePaginatedCollection($getAcceptanceRecords, 200);
    }

    public function getProjects(Request $request){
        $getProjectManagement = $this->projectManagementRepository->model()->orderBy('id')->get();
        $this->setTransformer(new ProjectManagementTransformer(true));
        $getSystemStatus = $this->systemStatusRepository->model()->orderBy('id')->get();
        $this->setTransformer(new SystemStatusTransformer(true));
        return response()->json([
            'getProjectManagement'=>$getProjectManagement,
            'getSystemStatus'=>$getSystemStatus,
        ], 200);
    }

    public function store(AcceptanceRecordStoreRequest $request)
    {
        $data = $request->all();
        DB::beginTransaction();
        try {
            $acceptanceRecord = $this->acceptanceRecordRepository->create($data);
            if ($request->hasFile('filesArr')) {
                $files = $request->file('filesArr');
                $timestamp = date('Y-m-d_H:i:s');
                foreach ($files as $item) {
                    $filePath = $this->uploadFile($item);
                    $acceptanceRecord->files()->create([
                        'name' => $filePath,
                        'path' => 'file-acceptance-records/' . $timestamp . '_' . $filePath,
                        'entry_id' => $acceptanceRecord->id,
                        'entry_type' => AcceptanceRecord::class
                    ]);
                }
            }
            DB::commit();
            return $this->successResponse(['acceptanceRecord' => $acceptanceRecord, 'message' => trans('Thêm thành công !')], 200);
        } catch (\Exception $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function show($id)
    {
        $getAcceptanceRecordsFirst = $this->acceptanceRecordRepository->findWithRelationships($id, ['project']);
        if(! $getAcceptanceRecordsFirst) {
            return $this->errorsResponse(['id' => trans('Biên bản nghiệm thu không tồn tại!')], 422);
        }
        return $this->successResponse(['acceptanceRecord' => $getAcceptanceRecordsFirst], 200);
    }

    public function uploadFile($file)
    {
        $filename = $file->getClientOriginalName();
        $timestamp = date('Y-m-d_H:i:s');

        $new_filename =   $timestamp . '_' . $filename;
        Storage::disk('public')->put('/file-acceptance-records/' . $new_filename, $file->getContent());
        return $filename;
    }

    public function update(AcceptanceRecordUpdateRequest $request, $id)
    {
        $data = $request->except('code');
        $entry = $this->acceptanceRecordRepository->findWithRelationships($id, ['files']);
        if (!$entry) {
            return $this->errorsResponse(['id' => trans('Không tồn tại!')], 422);
        }
        DB::beginTransaction();
        try {
            $acceptanceRecord = $entry->update($data);
            if ($request->hasFile('filesArr')) {
                $files = $request->file('filesArr');
                $timestamp = date('Y-m-d_H:i:s');
                
                foreach ($files as $item) {
                    $filePath = $this->uploadFile($item);
                    $entry->files()->create([
                        'name' => $filePath,
                        'path' => 'file-acceptance-records/' . $timestamp . '_' . $filePath,
                        'entry_id' => $entry->id,
                        'entry_type' => AcceptanceRecord::class
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
            DB::commit();
            return $this->successResponse(['acceptanceRecord' => $acceptanceRecord, 'message' => trans('Sửa thành công !')], 200);
        } catch (\Exception $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy(Request $request, $id)
    {
        $entry = $this->acceptanceRecordRepository->find($id);
        if (!$entry) {
            return $this->errorsResponse(["id" => trans("Không tồn tại !")], 404);
        }
        try {
            $entry->forceDelete($id);
            return $this->successResponse(['acceptanceRecord' => $entry, 'message' => trans('Xóa dữ liệu thành công!')], 200);
        } catch (\Exception $e) {
            return $this->errorResponse(['id' => $e->getMessage()]);
        }
    }
}
