<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SystemPermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\RequestTicketStoreRequest;
use App\Http\Requests\RequestTicketUpdateRequest;
use App\Http\Requests\workflowStoreRequest;
use App\Http\Requests\workflowUpdateRequest;
use App\Repositories\Interfaces\IDepartmentRepository;
use App\Repositories\Interfaces\IRequestTicketRepository;
use App\Repositories\Interfaces\IWorkflowRepository;
use App\Transformers\RequestTicketTransformer;
use App\Transformers\workflowTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function App\Helper\check_user_permission;

class WorkflowController extends Controller
{

    /**
     * @var IWorkflowRepository
     */
    private $workflowRepository;

    public function __construct(IWorkflowRepository $workflowRepository)
    {
        $this->workflowRepository = $workflowRepository;
    }

    public function index()
    {
        $breadcrums = [
            'text' => trans('Quản lý quy trình duyệt phiếu')
        ];
        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_WORKFLOW);
        $data = [
            'breadcrums' => $breadcrums,
            'pageName' => trans('Quản lý quy trình duyệt phiếu'),
            'btnAdd' => $btnAdd,
        ];
        return view('admin.workflow.index')->with($data);
    }

    public function getAllWorkflow(Request $request)
    {
        $workflowName = $request->workflow_name;
        $department_id = auth()->user()->department_id;

        $requestTickets = $this->workflowRepository->model()->with(['creator'])
            ->where(function ($query) use ($workflowName) {
                if ($workflowName) {
                    $query->where('workflow_name', 'like', '%' . $workflowName . '%');
                }

            })->where('valid', 1)
            ->when($request->check_permission_dept, function ($query) use ($department_id) {
                $query->whereRaw('FIND_IN_SET(?, dept_ids)', [$department_id]);
            })
            ->orderByDesc('id')->get();

        $this->setTransformer(new workflowTransformer());

        return $this->responseCollection(
            $requestTickets,
            200
        );
    }

    public function store(workflowStoreRequest $request)
    {
        $data = $request->all();

        $deptIds = $data['dept_ids'] ?? null;

        $data['dept_ids'] =  $deptIds ? implode(",", array_unique($data['dept_ids'])) : null;

        $data['approver_ids'] =  !empty($data['approver_ids']) ? implode(",", array_unique($data['approver_ids'])) : null;

        // phòng ban áp dụng

        if(in_array(null, $deptIds)) {
            $data['dept_ids'] = DB::table('departments')->pluck('id')->implode(',');
            $departmentNames =  DB::table('departments')->pluck('name');
            $data['department_names'] = $departmentNames->implode(', ');
        }else {
            $departmentNames =  DB::table('departments')->whereIn('id', $deptIds)->pluck('name');
            $data['department_names'] = $departmentNames->implode(', ');
        }

        DB::beginTransaction();
        try {
            $data['request_status'] = 0;
            $this->workflowRepository->create($data);
            DB::commit();
            return $this->successResponse(['message' => trans('Thêm quy trình duyệt thành công!')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function update($id, workflowUpdateRequest $request)
    {
        $workflow = $this->workflowRepository->find($id);

        if (! $workflow) {
            return $this->errorsResponse(['message' => trans('Quy trình duyệt không tồn tại.')], 422);
        }

        $data = $request->all();

        $deptIds = $data['dept_ids'] ?? null;

        $data['dept_ids'] =  $deptIds ? implode(",", array_unique($data['dept_ids'])) : null;

        $data['approver_ids'] =  !empty($data['approver_ids']) ? implode(",", array_unique($data['approver_ids'])) : null;

        // phòng ban áp dụng

        if(in_array(null, $deptIds)) {
            $data['dept_ids'] = DB::table('departments')->pluck('id')->implode(',');
            $departmentNames =  DB::table('departments')->pluck('name');
            $data['department_names'] = $departmentNames->implode(', ');
        }else {
            $departmentNames =  DB::table('departments')->whereIn('id', $deptIds)->pluck('name');
            $data['department_names'] = $departmentNames->implode(', ');
        }

        DB::beginTransaction();
        try {
            $workflow->update($data);
            DB::commit();
            return $this->successResponse(['request_ticket' => $workflow->refresh(), 'message' => trans('Sửa quy trình duyệt thành công!')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy($id)
    {
        $workflow = $this->workflowRepository->find($id);

        if (! $workflow) {
            return $this->errorsResponse(['message' => trans('Quy trình duyệt không tồn tại.')], 422);
        }

        DB::beginTransaction();
        try {
            $workflow->update(['valid' => 0]);
            DB::commit();
            return $this->successResponse(['message' => trans('Xóa quy trình duyệt thành công !')]);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return $this->errorResponse($throwable->getMessage());
        }
    }
}
