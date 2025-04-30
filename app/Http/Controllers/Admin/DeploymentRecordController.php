<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StatusEnum;
use App\Enums\SystemPermissionEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\IDeploymentRecordRepository;
use App\Repositories\Interfaces\IProjectManagementRepository;
use App\Repositories\Interfaces\ISystemStatusRepository;
use App\Transformers\DeploymentRecordTransformer;
use App\Transformers\ProjectManagementTransformer;
use App\Transformers\SystemStatusTransformer;
use App\Http\Requests\DeploymentRecordStoreRequest;
use App\Http\Requests\DeploymentRecordUpdateRequest;
use App\Models\DeploymentRecord;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\File;

use function App\Helper\check_user_permission;

class DeploymentRecordController extends Controller
{
    protected $deploymentRecordRepository;
    protected $projectManagementRepository;
    protected $systemStatusRepository;
    public function __construct(
        IDeploymentRecordRepository $deploymentRecordRepository,
        IProjectManagementRepository $projectManagementRepository,
        ISystemStatusRepository $systemStatusRepository,
    ) {
        $this->deploymentRecordRepository = $deploymentRecordRepository;
        $this->projectManagementRepository = $projectManagementRepository;
        $this->systemStatusRepository = $systemStatusRepository;
    }

    public function index()
    {
        $breadcrumbs = [
            [
                'link' => null,
                'text' => __('Danh sách biên bản triển khai')
            ],
        ];
        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_DEPLOYMENT_RECORD);
        $data = [
            'pageName' =>  trans('Danh sách biên bản triển khai'),
            'breadcrumbs' => $breadcrumbs,
            'btnAdd' => $btnAdd,
        ];
        return view('admin.deployment-records.index')->with($data);
    }

    public function getAllDeploymentRecords(Request $request)
    {
        $perPage = $request->per_page;
        if (!$perPage) {
            $perPage = 30;
        }

        $fromDate = $request->from_date;
        $toDate = $request->to_date;
        $project = $request->project;
        $handoverPerson = $request->handover_person;
        $receiver = $request->receiver;
        $status_id = $request->status_id;
        $getDeploymentRecords = $this->deploymentRecordRepository->model()
            ->with('project', 'status', 'files')
            ->where(function ($query) use (
                $fromDate,
                $toDate,
                $project,
                $handoverPerson,
                $receiver,
                $status_id,
            ) {
                if ($fromDate) {
                    $query->whereDate('handover_date', '>=', $fromDate);
                }
                if ($toDate) {
                    $query->whereDate('handover_date', '<=', $toDate);
                }
                if ($project) {
                    $query->whereHas('project', function ($q) use ($project) {
                        $q->where('name', 'like', '%' . $project . '%')
                            ->orWhere('code', 'like', '%' . $project . '%');
                    });
                }

                if ($handoverPerson) {
                    $query->where('handover_person', 'like', '%' . $handoverPerson . '%');
                }
                if ($receiver) {
                    $query->where('receiver', 'like', '%' . $receiver . '%');
                }
                if ($status_id) {
                    $query->where('status_id', '=', $status_id);
                }
            })
            ->orderBy('project_id')->orderByDesc('id');
        $getDeploymentRecordsClone = clone $getDeploymentRecords;
        $getHandoverPersons =  $getDeploymentRecordsClone->select('handover_person')->get()->toArray();
        $getDeploymentRecords = $getDeploymentRecords->paginate($perPage);
        $this->setTransformer(new DeploymentRecordTransformer(true, true));
        return $this->responsePaginatedCollection(
            $getDeploymentRecords,
            200,
            [
                'getHandoverPersons' => $getHandoverPersons
            ]
        );
    }

    public function getProjects(Request $request)
    {
        $getProjectManagement = $this->projectManagementRepository->model()->orderBy('id')->get();
        $this->setTransformer(new ProjectManagementTransformer(true));
        $getSystemStatus = $this->systemStatusRepository->model()->orderBy('id')->get();
        $this->setTransformer(new SystemStatusTransformer(true));
        return response()->json([
            'getProjectManagement' => $getProjectManagement,
            'getSystemStatus' => $getSystemStatus,
        ], 200);
    }

    public function store(DeploymentRecordStoreRequest $request)
    {
        $data = $request->all();
        DB::beginTransaction();
        try {
            $deploymentRecord = $this->deploymentRecordRepository->create($data);
            if ($request->hasFile('filesArr')) {
                $files = $request->file('filesArr');
                $timestamp = date('Y-m-d_H:i:s');
                foreach ($files as $item) {

                    $filePath = $this->uploadFile($item);
                    
                    $deploymentRecord->files()->create([
                        'name' => $filePath,
                        'path' => 'file-deployment-records/' . $timestamp . '_' . $filePath,
                        'entry_id' => $deploymentRecord->id,
                        'entry_type' => DeploymentRecord::class
                    ]);
                }
            }
            DB::commit();
            return $this->successResponse(['deploymentRecord' => $deploymentRecord, 'message' => trans('Thêm thành công !')], 200);
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
        Storage::disk('public')->put('/file-deployment-records/' . $new_filename, $file->getContent());
        // return $new_filename;
        return $filename;
    }

    public function update(DeploymentRecordUpdateRequest $request, $id)
    {
        $data = $request->except('code');
        $entry = $this->deploymentRecordRepository->findWithRelationships($id, ['files']);

        if (!$entry) {
            return $this->errorsResponse(['id' => trans('Không tồn tại!')], 422);
        }
        DB::beginTransaction();
        try {
            $deploymentRecord = $entry->update($data);
            if ($request->hasFile('filesArr')) {
                $files = $request->file('filesArr');
                $timestamp = date('Y-m-d_H:i:s');

                foreach ($files as $item) {
                    $filePath = $this->uploadFile($item);
                    $entry->files()->create([
                        'name' => $filePath,
                        'path' => 'file-deployment-records/' . $timestamp . '_' . $filePath,
                        'entry_id' => $entry->id,
                        'entry_type' => DeploymentRecord::class
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
            return $this->successResponse([
                'deploymentRecord' => $deploymentRecord,
                'message' => trans('Sửa thành công !')
            ], 200);
        } catch (\Exception $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    // public function update(DeploymentRecordUpdateRequest $request, $id)
    // {
    //     $data = $request->except('code');
    //     $entry = $this->deploymentRecordRepository->findWithRelationships($id, ['files']);

    //     if (!$entry) {
    //         return $this->errorsResponse(['id' => trans('Không tồn tại!')], 422);
    //     }
    //     DB::beginTransaction();
    //     try {
    //         $deploymentRecord = $entry->update($data);
    //         if ($request->hasFile('filesArr')) {
    //             $files = $request->file('filesArr');
    //             $timestamp = date('Y-m-d_H:i:s');
    //             $fileOldPaths = $entry->files->pluck('path')->toArray();
    //             if (count($fileOldPaths) > 0) {
    //                 foreach ($fileOldPaths as $filePath) {

    //                     $fileOldInStorage = substr($filePath, strrpos($filePath, '/') + 1);

    //                     if (Storage::disk('public')->exists('/file-deployment-records/' . $fileOldInStorage)) {

    //                         unlink(storage_path('app/public/file-deployment-records/' . $fileOldInStorage));
    //                     }
    //                 }
    //                 $entry->files()->delete();
    //             }

    //             foreach ($files as $item) {
    //                 $filePath = $this->uploadFile($item);
    //                 $entry->files()->create([
    //                     'name' => $filePath,
    //                     'path' => 'file-deployment-records/' . $timestamp . '_' . $filePath,
    //                     'entry_id' => $entry->id,
    //                     'entry_type' => DeploymentRecord::class
    //                 ]);
    //             }
    //         }
    //         DB::commit();
    //         return $this->successResponse([
    //             'deploymentRecord' => $deploymentRecord,
    //             'message' => trans('Sửa thành công !')
    //         ], 200);
    //     } catch (\Exception $th) {
    //         DB::rollBack();
    //         return $this->errorResponse($th->getMessage());
    //     }
    // }

    public function destroy(Request $request, $id)
    {
        $entry = $this->deploymentRecordRepository->find($id);
        if (!$entry) {
            return $this->errorsResponse(["id" => trans("Không tồn tại !")], 404);
        }
        try {
            $entry->forceDelete($id);
            return $this->successResponse(['deploymentRecord' => $entry, 'message' => trans('Xóa dữ liệu thành công!')], 200);
        } catch (\Exception $e) {
            return $this->errorResponse(['id' => $e->getMessage()]);
        }
    }
}
