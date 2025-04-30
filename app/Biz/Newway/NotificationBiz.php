<?php
namespace App\Biz\Newway;

use App\Models\Dispatch;
use App\Notifications\SendNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class NotificationBiz {

    public function updateNotificationReadAt($notificationId)
    {
        $notification = auth()->user()->notifications->where('id', $notificationId)->first();
        if(isset($notification->read_at)) {
            return true;
        }
        $notification && $notification->update(['read_at' => now()]);
        return true;
    }

    public function createNotifications($userHasPermission, $content)
    {
        Notification::send(
           $userHasPermission,
            new SendNotification($content)
        );
    }

    public function getDataDispatches($column, $isTodate)
    {
       return Dispatch::where($column, Carbon::now()->addDay()->format('Y-m-d'))
        ->with(['customer:id,name,code'])
        ->with(['project' => function($q) {
            $q->with('functionProjectHasUsers');
        }])
        ->get()->map(function($item) use($isTodate){
            $item->isTodate = $isTodate;
            return $item;
        });
    }
}
