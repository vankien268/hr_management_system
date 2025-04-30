<?php

namespace App\Repositories;

use App\Models\Notification;
use App\Models\User;

class NotificationRepository extends BaseRepository implements Interfaces\INotificationRepository
{
    public function __construct(Notification $model)
    {
        $this->model = $model;
    }

    public function getDataNotificationFilter($request)
    {
        $fromDateCreate = $request->from_date_create;
        $toDateCreate = $request->to_date_create;
        $projectId = $request->project_id;
        $customerId = $request->customer_id;
        $dispatchId = $request->dispatch_id;
        $fromDateExpiration = $request->from_date_expiration;
        $toDateExpiration = $request->to_date_expiration;
        $contactCode = $request->contract_code;
        $statusRead = $request->status_read;
        $acceptanceRecordId = $request->acceptance_record_id;

        $userLogin = auth()->user();
        $notifications = $this->model()->notifiableType(User::class, $userLogin->id)
                        ->where(function($query) use( $fromDateCreate,
                         $toDateCreate,
                         $projectId,
                         $customerId,
                         $dispatchId,
                         $fromDateExpiration,
                         $toDateExpiration,
                         $contactCode,
                         $statusRead,
                         $acceptanceRecordId
                         ) {
                                if($projectId) {
                                    # Dự án của các loại thông báo
                                    $projectId = (int)$projectId;

                                    $query->orWhere(function($q) use(
                                        $projectId,
                                    ) {
                                            $q
                                            ->whereJsonContains('data->payment_details->contract->project->id',  $projectId)
                                            ->orwhereJsonContains('data->dispatches->project->id', $projectId)
                                            ->orwhereJsonContains('data->acceptance_records->project->id', $projectId)
                                            ->orwhereJsonContains('data->contracts->project->id',$projectId);
                                        });

                                }

                                if($acceptanceRecordId) {
                                    $query->whereJsonContains('data->acceptance_records->id', (int)$acceptanceRecordId);
                                    }


                                if($statusRead != null) {
                                    $query->searchReadAt($statusRead);
                                }

                                if($dispatchId) {
                                    $query->whereJsonContains('data->dispatches->id', (int)$dispatchId);
                                }

                                if($contactCode) {
                                    $query->where(function($q) use(
                                        $contactCode,
                                    ) {
                                        $q->whereJsonContains('data->contracts->code', $contactCode)
                                        ->orWhereJsonContains('data->payment_details->contract->code', $contactCode);
                                        });
                                }

                                if($customerId) {
                                    $query->where(function($q) use(
                                        $customerId,
                                    ) {
                                        $q->whereJsonContains('data->contracts->customer->id',  (int)$customerId)
                                        ->orWhereJsonContains('data->payment_details->contract->customer->id',  (int)$customerId);
                                    });

                                }
                                if($fromDateCreate && $toDateCreate) {
                                    $query->searchDateInCreatedAt($fromDateCreate." 00:00:00",$toDateCreate." 23:59:59");

                                }

                                if($fromDateExpiration && $toDateExpiration) {

                                    $query->where(function($q) use($fromDateExpiration, $toDateExpiration) {
                                        #Ngày bắt đầu có hiệu lực công văn, thông báo

                                            $q->whereBetween('data->dispatches->from_date', [$fromDateExpiration, $toDateExpiration])
                                            ->whereJsonContains('data->dispatches->isTodate', false)

                                        #Ngày hết hạn hiệu lực công văn, thông báo
                                            ->orWhereBetween('data->dispatches->to_date', [$fromDateExpiration, $toDateExpiration])
                                            ->whereJsonContains('data->dispatches->isTodate', true)

                                        #Thời gian hết hạn biên bản nghiệm thu
                                            ->orWhereBetween('data->acceptance_records->expiration_time', [$fromDateExpiration, $toDateExpiration])

                                        #Thời gian hết hạn dự kiến thanh toán hợp đồng
                                            ->orWhereBetween('data->payment_details->expected_payment_date', [$fromDateExpiration, $toDateExpiration])

                                        #Thời gian hết hạn hợp đồng
                                            ->orWhereBetween('data->contracts->expiration_date', [$fromDateExpiration, $toDateExpiration]);
                                            });
                                }
                                return $query;

                        })
                        ;
        return $notifications;
    }
}
