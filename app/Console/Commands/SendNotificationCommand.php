<?php

namespace App\Console\Commands;

use App\Biz\Newway\NotificationBiz;
use App\Models\AcceptanceRecord;
use App\Models\Contract;
use App\Models\Dispatch;
use App\Models\PaymentDetail;
use App\Models\Project;
use App\Models\Role;
use App\Notifications\SendNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification as FacadesNotification;

class SendNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:send-notification-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
            $notification = new NotificationBiz();
            $role = Role::with('users')->find(1);
            $usersRole = $role->users->unique('id')->keyBy('id');

          // Cảnh báo hết hạn thời hạn hợp đồng
            $contracts = Contract::where('expiration_date', Carbon::now()->addDay()->format('Y-m-d'))
                        ->with(['customer' => function($query) {
                                            $query->select(['id', 'code', 'name']);

                        }])->with(['project' => function($query) {
                            $query->with('functionProjectHasUsersByPermission');
                        }])->get();


            foreach($contracts as $contract) {

                $notification->createNotifications(
                    $usersRole->replace($contract->project->functionProjectHasUsersByPermission->unique('id')->keyBy('id')),
                    $contract
                );
            }

          // Cảnh báo hết hạn thời gian dự kiến thanh toán hợp đồng
          $paymentDetails = PaymentDetail::where('expected_payment_date', Carbon::now()->addDay()->format('Y-m-d'))
            ->with(['contract' => function($query) {

                $query->with(['project' => function($query) {
                    $query->with('userPermissionViewPaymentDetailContract');
                }]);

                $query->with(['customer' => function($query) {
                    $query->select(['id', 'code', 'name']);

                }]);

            }])->get();

            foreach($paymentDetails as $paymentDetail) {
                $notification->createNotifications(
                    $usersRole->replace($paymentDetail->contract->project->userPermissionViewPaymentDetailContract->unique('id')->keyBy('id')),
                    $paymentDetail
                );
            }

        // Cảnh báo hết thời hạn biên bản nghiệm thu
        $projectOfAcceptanceRecords = AcceptanceRecord::whereRaw('DATE_ADD(acceptance_date, INTERVAL warranty_period MONTH) = ?', [Carbon::now()->addDay()->format('Y-m-d')])
                                    ->with(['project' => function($q) {
                                        $q->with('functionProjectHasUsers');
                                    }])->get()
                                    ->map(function($item) {
                                        $item->expiration_time =  Carbon::parse($item->acceptance_date)->addMonths($item->warranty_period)->format('Y-m-d');
                                        return $item;
                                    });

            foreach($projectOfAcceptanceRecords as $acceptanceRecord) {
                $notification->createNotifications(
                    $usersRole->replace($acceptanceRecord->project->functionProjectHasUsers->unique('id')->keyBy('id')),
                    $acceptanceRecord
                );
            }

        // Cảnh báo hết thời hạn công văn, thông báo

            $projectOfDispatchesToDate = $notification->getDataDispatches('to_date', true);

            foreach($projectOfDispatchesToDate as $dispatch) {
                $notification->createNotifications(
                    $usersRole->replace($dispatch->project->functionProjectHasUsers->unique('id')->keyBy('id')),
                    $dispatch
                );
            }


          // Cảnh báo bắt đầu đến thời hạn công văn, thông báo

            $projectOfDispatchesFromDate = $notification->getDataDispatches('from_date', false);

            foreach($projectOfDispatchesFromDate as $dispatch) {
                    $notification->createNotifications(
                        $usersRole->replace($dispatch->project->functionProjectHasUsers->unique('id')->keyBy('id')),
                        $dispatch
                    );
            }
    }
}
