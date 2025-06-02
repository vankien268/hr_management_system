<?php

namespace App\Http\Controllers\Admin;

use App\Enums\SystemPermissionEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApproveRequestTicketRequest;
use App\Http\Requests\RequestTicketStoreRequest;
use App\Http\Requests\RequestTicketUpdateRequest;
use App\Repositories\Interfaces\IRequestTicketRepository;
use App\Transformers\RequestTicketTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function App\Helper\check_user_permission;

class RequestTicketController extends Controller
{

    /**
     * @var IRequestTicketRepository
     */
    private $requestTicketRepository;

    public function __construct(IRequestTicketRepository$requestTicketRepository)
    {
        $this->requestTicketRepository = $requestTicketRepository;
    }

    public function index()
    {
        $breadcrums = [
            'text' => trans('Quản lý phiếu yêu cầu')
        ];
        $btnAdd = check_user_permission(SystemPermissionEnum::ADD_REQUEST_TICKET);
        $data = [
            'breadcrums' => $breadcrums,
            'pageName' => trans('Quản lý phiếu yêu cầu'),
            'btnAdd' => $btnAdd,
        ];
        return view('admin.request-tickets.index')->with($data);
    }

    public function getAllAllRequestTickets(Request $request)
    {
        $requestTitle = $request->request_title;
        $createdBy = $request->created_by;
        $requestStatus = $request->request_status;
        $year = $request->year ?? now()->year;

        $requestTickets = $this->requestTicketRepository->model()
            ->with(['creator', 'workflow'])
            ->join('workflows', function ($join) {
                $join->on('workflows.id', '=', 'request_tickets.workflow_id')
                    ->where('workflows.valid', 1);
            })
            ->select(
                'request_tickets.*',
                'workflows.approver_type',
                'workflows.approver_ids'
            )
            ->where(function ($query) use ($requestTitle, $createdBy, $requestStatus, $year) {
                if ($requestTitle) {
                    $query->where('request_title', 'like', '%' . $requestTitle . '%');
                }
                if ($createdBy) {
                    $query->where('created_by', $createdBy);
                }
                if ($requestStatus) {
                    $query->where('request_status', $requestStatus);
                }
                if ($year) {
                    $query->whereYear('request_tickets.created_at', $year);
                }
            })
            ->where('request_tickets.valid', 1)
            ->orderByDesc('request_tickets.id')
            ->get();

        $this->setTransformer(new RequestTicketTransformer());

        return $this->responseCollection(
            $requestTickets,
            200
        );
    }

    public function store(RequestTicketStoreRequest $request)
    {
        $data = $request->all();

        DB::beginTransaction();
        try {
            $data['request_status'] = 0;
            $this->requestTicketRepository->create($data);
            DB::commit();
            return $this->successResponse(['message' => trans('Thêm phiếu yêu cầu thành công!')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function update($id, RequestTicketUpdateRequest $request)
    {
        $requestTicket = $this->requestTicketRepository->find($id);

        if (! $requestTicket) {
            return $this->errorsResponse(['message' => trans('Phiếu yêu cầu không tồn tại.')], 422);
        }
        $data = $request->all();
        DB::beginTransaction();
        try {
            $data['request_status'] = 0;
            $requestTicket->update($data);
            DB::table('request_ticket_results')->where('request_ticket_id', $id)->delete();
            DB::commit();
            return $this->successResponse(['request_ticket' => $requestTicket->refresh(), 'message' => trans('Sửa phiếu yêu cầu thành công !')]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function handleApprove($id, ApproveRequestTicketRequest $request)
    {
        $requestTicket = $this->requestTicketRepository->find($id);

        if (! $requestTicket) {
            return $this->errorsResponse(['message' => trans('Phiếu yêu cầu không tồn tại.')], 422);
        }

        DB::beginTransaction();
        try {
            $requestTicket->update([
                'request_status' =>  $request->request_status
            ]);

            if($request->request_status == 1) {
                $message =trans('Duyệt phiếu thành công!.');

                $workflow = DB::table('workflows')->find($requestTicket->workflow_id);

                $createResultRequest = [
                  'request_ticket_id' => $id,
                    'result_type' => $workflow ?  $workflow->workflow_type : null,
                    'leave_day' => $requestTicket->start_date,
                    'number_leave_day' => $request->number_leave_day,
                    'working_shift_id' => $request->working_shift_id
                ];

                DB::table('request_ticket_results')->insert($createResultRequest);

            }else {
                $message =trans('Từ chối phiếu thành công!.');
            }

            DB::commit();
            return $this->successResponse(['request_ticket' => $requestTicket->refresh(), 'message' => $message]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function destroy($id)
    {
        $requestTicket = $this->requestTicketRepository->find($id);

        if (! $requestTicket) {
            return $this->errorsResponse(['message' => trans('Phiếu yêu cầu không tồn tại.')], 422);
        }

        DB::beginTransaction();
        try {
            $requestTicket->update(['valid' => 0]);
            DB::commit();
            return $this->successResponse(['message' => trans('Xóa phiếu yêu cầu thành công !')]);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return $this->errorResponse($throwable->getMessage());
        }
    }
}
