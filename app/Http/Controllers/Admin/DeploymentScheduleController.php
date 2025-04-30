<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Enums\StatusEnum;
use App\Models\ContractType;
use Illuminate\Http\Request;
use App\Models\ProjectImplementer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;
use App\Enums\SystemPermissionEnum;
use App\Http\Controllers\Controller;
use App\Models\DeploymentScheduleDetail;
use function App\Helper\check_user_permission;
use App\Transformers\DeploymentScheduleTransformer;
use App\Http\Requests\DeploymentScheduleStoreRequest;
use App\Http\Requests\DeploymentScheduleUpdateRequest;
use App\Http\Requests\searchDeploymentScheduleRequest;

use App\Repositories\Interfaces\IProjectManagementRepository;
use App\Repositories\Interfaces\IDeploymentScheduleRepository;

use PDF;

class DeploymentScheduleController extends Controller
{
    protected $deploymentScheduleRepository;
    protected $projectRepository;
    public function __construct(
        IDeploymentScheduleRepository $deploymentScheduleRepository,
        IProjectManagementRepository $projectRepository
    ) {
        $this->deploymentScheduleRepository = $deploymentScheduleRepository;
        $this->projectRepository = $projectRepository;
    }

    public function index()
    {
        $breadcrumbs = [
            [
                'link' => null,
                'text' => __('Khai báo lịch triển khai')
            ],
        ];
        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_DEPLOYMENT_SCHEDULE);
        $data = [
            'pageName' =>  trans('Khai báo lịch triển khai'),
            'breadcrumbs' => $breadcrumbs,
            'btnAdd' => $btnAdd,
        ];
        return view('admin.deployment-schedules.index')->with($data);
    }

    public function getAllDeploymentSchedule(searchDeploymentScheduleRequest $request)
    {
        $projectName = $request->projectNameOrCode;
        $title = $request->title;
        $status = $request->status;
        $fromDate = $request->from_date;
        $toDate = $request->to_date;
        $deploymentScheduleOfProject = $this->deploymentScheduleRepository->model()
            ->with(['project', 'users', 'deploymentScheduleDetails' => function ($query) {
                $query->orderBy('shift')->orderBy('day');
            }])
            ->where(function ($query) use ($projectName, $title, $status, $fromDate, $toDate) {
                if ($projectName) {
                    $query->whereHas('project', function ($q) use ($projectName) {
                        $q->where('name', 'like', '%' . $projectName . '%')->orWhere('code', $projectName);
                    });
                }
                if ($title) {
                    $query->where('title', 'like', '%' . $title . '%');
                }
                if ($status != null) {
                    $query->where('status_id', $status);
                }
                if ($fromDate && $toDate) {
                    $query->whereDate('from_date', '<=', $toDate)->whereDate('to_date', '>=', $fromDate);
                }
            })
            ->orderByDesc('id')->paginate($request->per_page ?? 30);
        $this->setTransformer(new DeploymentScheduleTransformer(true));
        $contractTypes = ContractType::select(['id', 'name', 'status'])->status()->get()->toArray();
        return $this->responsePaginatedCollection($deploymentScheduleOfProject, 200, ['contractTypes' => $contractTypes]);
    }

    public function store(DeploymentScheduleStoreRequest $request)
    {
        $data = $request->all();
        $deploymentSchedules = $data['deploymentSchedule']['data'][0];
        $deploymentScheduleDetails = $data['deploymentScheduleDetail']['data'];
        $errors = $this->checkDuplicateDayDetail($deploymentScheduleDetails);
        if(count($errors)) {
            return $this->errorsResponse($errors, 422);
        }
        $projectImplementers = array_column($data['projectImplementer']['data'], 'id');
        $deploymentScheduleDetailNews = [];
        DB::beginTransaction();
        try {
            # Thêm lịch triển khai
            $deploymentScheduleStore = $this->deploymentScheduleRepository->create($deploymentSchedules);
            $deploymentScheduleId =  $deploymentScheduleStore->id;
            # Thêm chi tiết lịch triển khai
            array_map(function ($item) use ($deploymentScheduleId, &$deploymentScheduleDetailNews) {
                foreach ($item as $key => $rows) {
                    $item[$key]['deployment_schedule_id'] = $deploymentScheduleId;
                    $item[$key]['created_at'] = Carbon::now();
                    $item[$key]['updated_at'] = Carbon::now();
                    unset($item[$key]['idSave']);
                    array_push($deploymentScheduleDetailNews,  $item[$key]);
                }
                return $item;
            }, $deploymentScheduleDetails);
            DeploymentScheduleDetail::insert($deploymentScheduleDetailNews);
            # Thêm chuyên viên lịch triển khai
            $deploymentScheduleStore->users()->attach($projectImplementers);
            DB::commit();
            return $this->successResponse(['message' => trans('Thêm lịch triển khai thành công !')], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function checkDuplicateDayDetail($data)
    {
        $errors = new MessageBag();
        $lengthData = count($data);

        if($lengthData > 0) {
            for($i = 0; $i < $lengthData; $i ++) {
                for($j = $i + 1; $j < $lengthData; $j ++) {
                    if($data[$i][0]['day'] == $data[$j][0]['day'])
                        $errors->add('deploymentScheduleDetail.data.'.$j.'.0.day', trans('Ngày chọn đã bị trùng.'));
                }
            }
        }
        return $errors;
    }

    public function update(DeploymentScheduleUpdateRequest $request, $id)
    {
        $deploymentSchedule = $this->deploymentScheduleRepository->findWithRelationships($id, ['project', 'users', 'deploymentScheduleDetails']);
        if (!$deploymentSchedule) {
            return $this->errorsResponse(['message' => trans('Không tồn tại lịch triển khai.')], 422);
        }
        $data = $request->all();
        $deploymentSchedules = $data['deploymentSchedule']['data'][0];

        if (array_key_exists('code', $data['deploymentSchedule']['data'][0])) {
            unset($data['deploymentSchedule']['data'][0]['code']);
        }
        $deploymentScheduleDetails = $data['deploymentScheduleDetail']['data'];
        $projectImplementers = array_column($data['projectImplementer']['data'], 'id');
        $errors = $this->checkDuplicateDayDetail($deploymentScheduleDetails);
        if(count($errors)) {
            return $this->errorsResponse($errors, 422);
        }
        $deploymentScheduleDetailNews = [];
        DB::beginTransaction();
        try {
            # Sửa lịch triển khai
            $deploymentSchedule->update($deploymentSchedules);
            $deploymentScheduleId =  $deploymentSchedule->id;
            #xóa
            if ($request->get('destroyDeployDetailIds')) {
                $deployDetailIds = $request->get('destroyDeployDetailIds');
                $deploymentSchedule->deploymentScheduleDetails->find($deployDetailIds)
                    ->each(function ($item) {
                        $item->delete();
                    });
            }
            # Sửa
            array_map(function ($item) use (
                $deploymentScheduleId,
                &$deploymentScheduleDetailNews,
            ) {
                foreach ($item as $key => $rows) {
                    if ($rows['id'] == 0) {
                        $item[$key]['deployment_schedule_id'] = $deploymentScheduleId;
                        $item[$key]['created_at'] = Carbon::now();
                        $item[$key]['updated_at'] = Carbon::now();
                        unset($item[$key]['idSave']);
                        array_push($deploymentScheduleDetailNews,  $item[$key]);
                    } else {
                        // sửa dựa trên id cũ
                        $attributeRow = [...$rows];
                        unset($attributeRow['id']);
                        DeploymentScheduleDetail::find($rows['id'])->update($attributeRow);
                    }
                }
                return $item;
            }, $deploymentScheduleDetails);
            DeploymentScheduleDetail::insert($deploymentScheduleDetailNews);

            $deploymentSchedule->users()->sync($projectImplementers);
            DB::commit();
            return $this->successResponse(['message' => trans('Sửa lịch triển khai thành công !')], 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy($id)
    {
        $deploymentSchedule = $this->deploymentScheduleRepository->findWithRelationships($id, ['users', 'deploymentScheduleDetails']);
        if (!$deploymentSchedule) {
            return $this->errorsResponse(['message' => trans('Không tồn tại lịch triển khai.')], 422);
        }
        DB::beginTransaction();
        try {
            $deploymentSchedule->users()->detach();
            $deploymentSchedule->deploymentScheduleDetails()->delete();
            $deploymentSchedule->delete();
            DB::commit();
            return $this->successResponse(['message' => trans('Xóa dự án thành công !')], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function exportFilePdf(Request $request)
    {
        $deploymentScheduleOfProject = $this->deploymentScheduleRepository->model()
            ->with(['project', 'users', 'contractType','status', 'deploymentScheduleDetails' => function ($query) {
                $query->orderBy('shift')->orderBy('day');
            }])->find($request->id);
        if(!$deploymentScheduleOfProject) {
            return $this->errorsResponse(['message' => trans('Không tồn tại lịch triển khai.')], 422);
        }
        $getData = fractal($deploymentScheduleOfProject, new DeploymentScheduleTransformer(true));
        $view = view('admin.deployment-schedules.export-pdf-deploy-schedule', $getData->toArray());
        $pdf = PDF::loadHTML($view, "UTF-8");
        return $pdf->download('DetailDeploymentSchedule.pdf');
    }
}
