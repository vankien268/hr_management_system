<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchNotificationRequest;
use App\Models\Contract;
use App\Models\Notification as ModelsNotification;
use App\Models\Project;
use App\Models\User;
use App\Notifications\SendNotification;
use App\Repositories\Interfaces\IContractRepository;
use App\Repositories\Interfaces\INotificationRepository;
use App\Repositories\Interfaces\ISystemStatusRepository;
use App\Transformers\NotificationTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification as FacadesNotification;

class NotificationController extends Controller
{
    protected $notificationRepository;
    protected $contractTypeRepository;
    protected $systemStatusRepository;

    public function __construct(INotificationRepository $notificationRepository,
    ISystemStatusRepository $systemStatusRepository,
    IContractRepository $contractTypeRepository,
    )
    {
        $this->notificationRepository = $notificationRepository;
        $this->systemStatusRepository = $systemStatusRepository;
        $this->contractTypeRepository = $contractTypeRepository;
        $this->setTransformer(new NotificationTransformer());
    }

    public function index()
    {
        $data = [
            // 'breadcrums' => $breadcrums,
            'pageName' => trans('Quản lý cảnh báo')
        ];
        return view('admin.notifications.index')->with($data);
    }

    public function getNotificationAll(SearchNotificationRequest $request)
    {
        $perPage = $request->per_page;
        if(!$perPage) {
            $perPage = 30;
        }
        $notifications = $this->notificationRepository->getDataNotificationFilter($request)->orderByDesc('created_at')->paginate($perPage);
        $contractTypes = $this->contractTypeRepository->getData()->get();
        $statuses = $this->systemStatusRepository->getData()->get();
        return $this->responsePaginatedCollection($notifications, 200, ['contractTypes' => $contractTypes, 'statuses' => $statuses]);
    }

    public function maskReadNotification() {
       auth()->user()->notifications->markAsRead();
        return $this->successResponse(['message' => trans('Cập nhật thành công !')]);
    }

    public function maskReadNotificationById($id) {
        $notification = auth()->user()->notifications->where('id', $id);
        if(!$notification) {
            return $this->errorsResponse(['message' => trans('Thông báo không tồn tại.')], 422);
        }
        $notification->markAsRead();
         return $this->successResponse(['notification' => $notification->first(),'message' => trans('Đọc thông báo thành công !')]);
     }
}
