<?php

use App\Http\Controllers\Admin\AllowanceController;
use App\Http\Controllers\Admin\HrmContactController;
use App\Http\Controllers\Admin\HrmContractController;
use App\Http\Controllers\Admin\InternalFundController;
use App\Http\Controllers\Admin\RequestTicketController;
use App\Http\Controllers\Admin\SalaryGradeController;
use App\Http\Controllers\Admin\TaxesController;
use App\Http\Controllers\Admin\TimekeepingController;
use App\Http\Controllers\Admin\TimeKeepingUserController;
use App\Http\Controllers\Admin\UserLeaveDayController;
use App\Http\Controllers\Admin\WorkflowController;
use App\Http\Controllers\Admin\WorkingShiftSettingController;
use App\Http\Controllers\InitValueController;
use App\Http\Controllers\SettingController;
use App\Models\Notification;
use Illuminate\Support\Facades\Route;
use League\CommonMark\Node\Block\Document;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\WardController;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\PrintController;
use App\Http\Controllers\Admin\QuoteController;
use App\Http\Controllers\Api\DistrictController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ContractController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DispatchController;
use App\Http\Controllers\Admin\OrderCrudController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\TaxFeeRateController;
use App\Http\Controllers\Admin\ProjectTypeController;
use App\Http\Controllers\Admin\ContractTypeController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ProductGroupController;
use App\Http\Controllers\Admin\SystemStatusController;
use App\Http\Controllers\Admin\SystemFuntionController;
use App\Http\Controllers\Admin\AcceptanceRecordController;
use App\Http\Controllers\Admin\DeploymentRecordController;
use App\Http\Controllers\Admin\ProjectManagementController;
use App\Http\Controllers\Admin\DeploymentScheduleController;
use App\Http\Controllers\Admin\Report\ProjectReportController;
use App\Http\Controllers\Admin\Report\ContractReportController;
use App\Http\Controllers\Admin\Report\CustomerReportController;
use App\Http\Controllers\Admin\Report\DispatchReportController;
use App\Http\Controllers\Admin\Report\AcceptanceRecordReportController;
use App\Http\Controllers\Admin\Report\DeploymentRecordReportController;
use App\Http\Controllers\Admin\Report\PaymentDetailProjectReportController;
use App\Http\Controllers\Admin\Report\PaymentDetailContractReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//['auth', 'permission']
Route::name('admin.')->prefix('/')->middleware(['auth', 'permission'])->group(function () {
    Route::get('/dashboard', function () {
        // ['pageName' => 'Dashboard']
        return view('admin.dashboard',
        [
            'pageName' => trans('Trang chủ'),
        ]);
    })->name('dashboard');

    Route::prefix('test-print')->group(function () {
        Route::get('/students', [PrintController::class, 'index']);
    });

    Route::prefix('system-status')->group(function () {
        Route::get('/', [SystemStatusController::class, 'view'])->name('statuses.view');
        Route::resource('/api', SystemStatusController::class);
    });



    Route::prefix('contracts')->group(function () {
        Route::get('/', [ContractController::class, 'view'])->name('contract.view');
        Route::resource('/api', ContractController::class);

        Route::get('show', [ContractController::class, 'showContractHistory']);
        Route::get('getOther', [ContractController::class, 'getOther']);

        Route::get('/types', [ContractTypeController::class, 'view'])->name('contract_type.view');
        Route::resource('/types/api', ContractTypeController::class);
    });

    Route::prefix('customers')->group(function () {
        Route::get('/', [CustomerController::class, 'view'])->name('customers.view');
        Route::resource('/api', CustomerController::class);

        Route::get('show', [CustomerController::class, 'showCustomerHistory']);
        Route::get('getOther', [CustomerController::class, 'getOther']);
    });

    Route::prefix('products/groups')->group(function () {
        Route::get('/', [ProductGroupController::class, 'view'])->name('product_group.view');
        Route::resource('/api', ProductGroupController::class);
        Route::put('/api/move-up/{id}', [ProductGroupController::class, 'moveUp']);
        Route::put('/api/move-down/{id}', [ProductGroupController::class, 'moveDown']);
    });

    Route::prefix('quotes')->group(function () {
        Route::get('/', [QuoteController::class, 'view'])->name('quote.view');
        Route::get('/api/get_list_status', [QuoteController::class, 'getListStatus']);
        Route::put('/api/approve/{id}', [QuoteController::class, 'approveQuote']);
        Route::resource('/api', QuoteController::class);
        Route::get('/export-file-pdf/{id}', [QuoteController::class, 'exportFilePdf']);
    });

    Route::prefix('system-functions')->group(function () {
        Route::get('/', [SystemFuntionController::class, 'view'])->name('system_function.view');
        Route::resource('/api', SystemFuntionController::class);
    });

    /**
     * api address
     */
    Route::prefix('api')->group(function () {
        Route::resource('/cities', CityController::class);
        Route::resource('/districts', DistrictController::class);
        Route::resource('/wards', WardController::class);
    });

    Route::prefix('departments')->group(function () {
        Route::get('/', [DepartmentController::class, 'index'])->name('departments.index');
        Route::post('/store', [DepartmentController::class, 'store'])->name('departments.store');
        Route::post('/update/{id}', [DepartmentController::class, 'update'])->name('departments.update');
        Route::delete('/destroy/{id}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
        Route::get('/get-all', [DepartmentController::class, 'getAllDepartments'])->name('departments.getAllDepartments');
    });
    Route::prefix('project-types')->group(function () {
        Route::get('/', [ProjectTypeController::class, 'index'])->name('project_types.index');
        Route::post('/store', [ProjectTypeController::class, 'store'])->name('project_types.store');
        Route::post('/update/{id}', [ProjectTypeController::class, 'update'])->name('project_types.update');
        Route::delete('/destroy/{id}', [ProjectTypeController::class, 'destroy'])->name('project_types.destroy');
        Route::get('/get-all', [ProjectTypeController::class, 'getProjectTypes'])->name('project_types.getProjectTypes');
    });
    Route::prefix('users')->group(function () {
        Route::get('/profile/{id}', [UserController::class, 'view_profile'])->name('users.profile');
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::post('/store', [UserController::class, 'store'])->name('users.store');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/destroy/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::post('/change-password/{id}', [UserController::class, 'changePassword'])->name('users.changePassword');
        Route::get('/get-all', [UserController::class, 'getAllUsers'])->name('users.getAllUsers');
        Route::get('/profile', [UserController::class, 'profile'])->name('users.profile.index');
        Route::post('/store-profile', [UserController::class, 'storeProfile'])->name('users.profile');
    });
    Route::prefix('banks')->group(function () {
        Route::get('/', [BankController::class, 'index'])->name('banks.index');
        Route::post('/store', [BankController::class, 'store'])->name('banks.store');
        Route::post('/update/{id}', [BankController::class, 'update'])->name('banks.update');
        Route::delete('/destroy/{id}', [BankController::class, 'destroy'])->name('banks.destroy');
        Route::get('/get-all', [BankController::class, 'getAllBanks'])->name('banks.getAllBanks');
    });
    Route::prefix('units')->group(function () {
        Route::get('/', [UnitController::class, 'index'])->name('units.index');
        Route::post('/store', [UnitController::class, 'store'])->name('units.store');
        Route::post('/update/{id}', [UnitController::class, 'update'])->name('units.update');
        Route::delete('/destroy/{id}', [UnitController::class, 'destroy'])->name('units.destroy');
        Route::get('/get-all', [UnitController::class, 'getAllUnits'])->name('units.getAllUnits');
    });
    Route::prefix('tax-fee-rates')->group(function () {
        Route::get('/', [TaxFeeRateController::class, 'index'])->name('tax-fee-rates.index');
        Route::post('/store', [TaxFeeRateController::class, 'store'])->name('tax-fee-rates.store');
        Route::post('/update/{id}', [TaxFeeRateController::class, 'update'])->name('tax-fee-rates.update');
        Route::delete('/destroy/{id}', [TaxFeeRateController::class, 'destroy'])->name('tax-fee-rates.destroy');
        Route::get('/get-all', [TaxFeeRateController::class, 'getAllTaxFeeRates'])->name('tax-fee-rates.getAllTaxFeeRates');
    });
    Route::prefix('deployment-records')->group(function () {
        Route::get('/', [DeploymentRecordController::class, 'index'])->name('deployment-records.index');
        Route::post('/store', [DeploymentRecordController::class, 'store'])->name('deployment-records.store');
        Route::post('/update/{id}', [DeploymentRecordController::class, 'update'])->name('deployment-records.update');
        Route::delete('/destroy/{id}', [DeploymentRecordController::class, 'destroy'])->name('deployment-records.destroy');
        Route::get('/get-all', [DeploymentRecordController::class, 'getAllDeploymentRecords'])->name('deployment-records.getAllDeploymentRecords');
        Route::get('/get-projects', [DeploymentRecordController::class, 'getProjects'])->name('deployment-records.getProjects');
        Route::post('/upload-file', [DeploymentRecordController::class, 'uploadFile']);
        Route::get('/file-name/{id}', [DeploymentRecordController::class, 'fileName']);

    });
    Route::prefix('acceptance-records')->group(function () {
        Route::get('/', [AcceptanceRecordController::class, 'index'])->name('acceptance-records.index');
        Route::post('/store', [AcceptanceRecordController::class, 'store'])->name('acceptance-records.store');
        Route::post('/update/{id}', [AcceptanceRecordController::class, 'update'])->name('acceptance-records.update');
        Route::delete('/destroy/{id}', [AcceptanceRecordController::class, 'destroy'])->name('acceptance-records.destroy');
        Route::get('/get-all', [AcceptanceRecordController::class, 'getAllAcceptanceRecords'])->name('acceptance-records.getAllAcceptanceRecords');
        Route::get('/get-projects', [AcceptanceRecordController::class, 'getProjects'])->name('acceptance-records.getProjects');
        Route::get('/show/{id}', [AcceptanceRecordController::class, 'show'])->name('acceptance-records.show');
    });
    Route::prefix('dispatches')->group(function () {
        Route::get('/', [DispatchController::class, 'index'])->name('dispatches.index');
        Route::post('/store', [DispatchController::class, 'store'])->name('dispatches.store');
        Route::post('/update/{id}', [DispatchController::class, 'update'])->name('dispatches.update');
        Route::delete('/destroy/{id}', [DispatchController::class, 'destroy'])->name('dispatches.destroy');
        Route::get('/get-all', [DispatchController::class, 'getAllDispatches'])->name('dispatches.getAllDispatches');
        Route::get('/get-projects-customers', [DispatchController::class, 'getProjectsCustomers'])->name('dispatches.getProjectsCustomers');
        Route::get('/show/{id}', [DispatchController::class, 'show']);
    });
    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index');
        Route::post('/store', [RoleController::class, 'store'])->name('roles.store');
        Route::post('/update/{id}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/destroy/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
        Route::get('/get-all', [RoleController::class, 'getAllRoles'])->name('roles.getAllRoles');
    });
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::prefix('customers')->group(function () {
            Route::get('/', [CustomerReportController::class, 'index'])->name('customers.index');
            Route::get('get-all', [CustomerReportController::class, 'getAllCustomers'])->name('customers.getAllCustomers');
            Route::get('getOther', [CustomerReportController::class, 'getOther'])->name('customers.getOther');
        });
        Route::prefix('projects')->group(function () {
            Route::get('/', [ProjectReportController::class, 'index'])->name('projects.index');
            Route::get('get-all', [ProjectReportController::class, 'getAllProjects'])->name('projects.getAllProjects');
            Route::get('getOther', [ProjectReportController::class, 'getOther'])->name('projects.getOther');
        });
        Route::prefix('contracts')->group(function () {
            Route::get('/', [ContractReportController::class, 'index'])->name('contracts.index');
            Route::get('get-all', [ContractReportController::class, 'getAllContracts'])->name('contracts.getAllContracts');
            Route::get('getOther', [ContractReportController::class, 'getOther'])->name('contracts.getOther');
        });
        Route::prefix('dispatches')->group(function () {
            Route::get('/', [DispatchReportController::class, 'index'])->name('dispatches.index');
            Route::get('get-all', [DispatchReportController::class, 'getAllDispatches'])->name('dispatches.getAllDispatches');
            Route::get('getOther', [DispatchReportController::class, 'getOther'])->name('dispatches.getOther');
        });
        Route::prefix('payment-details-contracts')->group(function () {
            Route::get('/', [PaymentDetailContractReportController::class, 'index'])->name('payment-details.index');
            Route::get('get-all', [PaymentDetailContractReportController::class, 'getAllPaymentDetails'])->name('payment-details.getAllPaymentDetails');
            Route::get('getOther', [PaymentDetailContractReportController::class, 'getOther'])->name('payment-details.getOther');
        });
        Route::prefix('acceptance-records')->group(function () {
            Route::get('/', [AcceptanceRecordReportController::class, 'index'])->name('acceptance-records.index');
            Route::get('get-all', [AcceptanceRecordReportController::class, 'getAllAcceptanceRecords'])->name('acceptance-records.getAllAcceptanceRecords');
            Route::get('getOther', [AcceptanceRecordReportController::class, 'getOther'])->name('acceptance-records.getOther');
        });
        Route::prefix('deployment-records')->group(function () {
            Route::get('/', [DeploymentRecordReportController::class, 'index'])->name('deployment-records.index');
            Route::get('get-all', [DeploymentRecordReportController::class, 'getAllDeploymentRecords'])->name('deployment-records.getAllDeploymentRecords');
            Route::get('getOther', [DeploymentRecordReportController::class, 'getOther'])->name('deployment-records.getOther');
        });
        Route::prefix('payment-detail-projects')->group(function () {
            Route::get('/', [PaymentDetailProjectReportController::class, 'index'])->name('payment-detail-projects.index');
            Route::get('get-all', [PaymentDetailProjectReportController::class, 'getAllPaymentDetailProjects'])->name('payment-detail-projects.getAllPaymentDetailProjects');
            Route::get('getOther', [PaymentDetailProjectReportController::class, 'getOther'])->name('payment-detail-projects.getOther');
        });
    });

    Route::prefix('projects')->group(function () {
        Route::get('/', [ProjectManagementController::class, 'index'])->name('projects-management.index');
        Route::post('/store', [ProjectManagementController::class, 'store'])->name('projects-management.store');
        Route::post('/update/{id}', [ProjectManagementController::class, 'update'])->name('projects-management.update');
        Route::delete('/destroy/{id}', [ProjectManagementController::class, 'destroy'])->name('projects-management.destroy');
        Route::get('/get-all', [ProjectManagementController::class, 'getAllProjects'])->name('projects-management.getAllUsers');
        Route::get('/getOther', [ProjectManagementController::class, 'getOther']);
        // Người đại diện phía khách hàng trong dự án
        Route::post('/store-contact-by-project', [ContactController::class, 'storeByProject'])->name('projects-management.contact.store');
        // Người đại diện phía công ty tronng dự án
         Route::post('/store-user-by-project', [ProjectManagementController::class, 'storeUserByProject'])->name('projects-management.user.store');
        // Nhật ký dự án
        Route::post('/store-task-by-project', [ProjectManagementController::class, 'storeTaskByProject'])->name('projects-management.task.store');
        // Phân quyền dự án
        Route::post('/store-permission-project', [ProjectManagementController::class, 'storePermissionProject']);
        // Lịch sử dự án
        Route::get('/get-histories/{id}', [ProjectManagementController::class, 'historyUpdateProject'])->name('projects-management.getAllUsers');
    });
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    // # Khai báo sản phẩm
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('products.index');
        Route::post('/store', [ProductController::class, 'store'])->name('products.store');
        Route::post('/update/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::get('/get-all', [ProductController::class, 'getAllProducts'])->name('products.getAllProducts');
    });
    // Quản lý lịch triển khai

    Route::prefix('deployment-schedule')->group(function () {
        Route::get('/', [DeploymentScheduleController::class, 'index'])->name('deployment_schedule.index');
        Route::post('/store', [DeploymentScheduleController::class, 'store'])->name('deployment_schedule.store');
        Route::post('/update/{id}', [DeploymentScheduleController::class, 'update'])->name('deployment_schedule.update');
        Route::delete('/destroy/{id}', [DeploymentScheduleController::class, 'destroy'])->name('deployment_schedule.destroy');
        Route::get('/get-all', [DeploymentScheduleController::class, 'getAllDeploymentSchedule'])->name('deployment_schedule.getAllDeploymentSchedule');
        Route::get('/export-file-pdf/{id}', [DeploymentScheduleController::class, 'exportFilePdf']);
    });

    // Notification
    Route::prefix('notification')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('notification.index');
        Route::get('/get-all', [NotificationController::class, 'getNotificationAll']);
        Route::post('/read-notification/{id}', [NotificationController::class, 'maskReadNotificationById']);
    });

    Route::post('/update-mask-read', [NotificationController::class, 'maskReadNotification']);

    Route::prefix('exportExcel')->group(function () {
        Route::get('/customer', [CustomerReportController::class, 'exportExcel'])->name('customer.exportExcel');
        Route::get('/project', [ProjectReportController::class, 'exportExcel'])->name('project.exportExcel');
        Route::get('/contract', [ContractReportController::class, 'exportExcel'])->name('contract.exportExcel');
        Route::get('/dispatch', [DispatchReportController::class, 'exportExcel'])->name('dispatch.exportExcel');
        Route::get('/payment-detail-contract', [PaymentDetailContractReportController::class, 'exportExcel'])->name('payment-detail-contract.exportExcel');
        Route::get('/acceptance-record', [AcceptanceRecordReportController::class, 'exportExcel'])->name('acceptance-record.exportExcel');
        Route::get('/deployment-record', [DeploymentRecordReportController::class, 'exportExcel'])->name('deployment-record.exportExcel');
    });

    Route::get('/print-customer', [CustomerReportController::class, 'printReport']);
    Route::get('/print-test', [CustomerReportController::class, 'printTest']);

    // # Khai báo phụ cấp
    Route::prefix('allowances')->group(function () {
        Route::get('/', [AllowanceController::class, 'index'])->name('allowances.index');
        Route::post('/store', [AllowanceController::class, 'store'])->name('allowances.store');
        Route::post('/update/{id}', [AllowanceController::class, 'update'])->name('allowances.update');
        Route::delete('/destroy/{id}', [AllowanceController::class, 'destroy'])->name('allowances.destroy');
        Route::get('/get-all', [AllowanceController::class, 'getAllAllowances'])->name('allowances.getAllAllowances');
    });

    // # Khai báo phiếu yêu cầu
    Route::prefix('request-tickets')->group(function () {
        Route::get('/', [RequestTicketController::class, 'index'])->name('request-tickets.index');
        Route::post('/store', [RequestTicketController::class, 'store'])->name('request-tickets.store');
        Route::post('/update/{id}', [RequestTicketController::class, 'update'])->name('request-tickets.update');
        Route::put('/approve/{id}', [RequestTicketController::class, 'handleApprove'])->name('request-tickets.approve');
        Route::delete('/destroy/{id}', [RequestTicketController::class, 'destroy'])->name('request-tickets.destroy');
        Route::get('/get-all', [RequestTicketController::class, 'getAllAllRequestTickets'])->name('request-tickets.getAllAllRequestTickets');
    });

    // # Khai báo quy trình duyệt
    Route::prefix('workflow')->group(function () {
        Route::get('/', [WorkflowController::class, 'index'])->name('workflow.index');
        Route::post('/store', [WorkflowController::class, 'store'])->name('workflow.store');
        Route::post('/update/{id}', [WorkflowController::class, 'update'])->name('workflow.update');
        Route::delete('/destroy/{id}', [WorkflowController::class, 'destroy'])->name('workflow.destroy');
        Route::get('/get-all', [WorkflowController::class, 'getAllWorkflow'])->name('workflow.getAllWorkflow');
    });

    // # Khai báo phụ cấp
    Route::prefix('internal-fund')->group(function () {
        Route::get('/', [InternalFundController::class, 'index'])->name('internal-fund.index');
        Route::put('/update', [InternalFundController::class, 'update'])->name('internal-fund.update');
        Route::get('/info', [InternalFundController::class, 'getInfoInternalFund'])->name('internal-fund.getInfoInternalFund');
    });

    Route::prefix('salary-grades')->group(function () {
        Route::get('/', [SalaryGradeController::class, 'index'])->name('salary-grades.index');
        Route::put('/update', [SalaryGradeController::class, 'update'])->name('salary-grades.update');
        Route::get('/get-info', [SalaryGradeController::class, 'getInfoSalaryGrades'])->name('salary-grades.getInfoSalaryGrades');
    });

    Route::prefix('timekeepings')->group(function () {
        Route::get('/', [TimekeepingController::class, 'index'])->name('timekeepings.index');
        Route::put('/update', [TimekeepingController::class, 'update'])->name('timekeepings.update');
        Route::get('/get-info', [TimekeepingController::class, 'getInfoTimekeepings'])->name('timekeepings.getInfoTimekeepings');
    });

    Route::prefix('timekeeping-users')->group(function () {
        Route::get('/', [TimeKeepingUserController::class, 'index'])->name('timekeeping-users.index');
        Route::put('/update', [TimeKeepingUserController::class, 'update'])->name('timekeeping-users.update');
        Route::get('/get-all', [TimeKeepingUserController::class, 'getInfoTimekeepingUsers'])->name('timekeeping-users.getInfoTimekeepingUsers');
    });

    // # Khai báo nhân sự
    Route::prefix('hrm-contacts')->group(function () {
        Route::get('/', [HrmContactController::class, 'index'])->name('hrm-contacts.index');
        Route::put('/update/{id}', [HrmContactController::class, 'update'])->name('hrm-contacts.update');
        Route::get('/get-all', [HrmContactController::class, 'getAllHrmContact'])->name('hrm-contacts.getAllHrmContact');
    });

    // # Cấu hình nghỉ phép
    Route::prefix('user-leave-days')->group(function () {
        Route::get('/', [UserLeaveDayController::class, 'index'])->name('user-leave-days.index');
        Route::put('/update', [UserLeaveDayController::class, 'update'])->name('user-leave-days.update');
        Route::get('/info', [UserLeaveDayController::class, 'getInfoNumberOfMonthlyLeaveDays'])->name('user-leave-days.getInfoNumberOfMonthlyLeaveDays');
    });

    // # Khai báo thuế phí
    Route::prefix('taxes')->group(function () {
        Route::get('/', [TaxesController::class, 'index'])->name('taxes.index');
        Route::post('/store', [TaxesController::class, 'store'])->name('taxes.store');
        Route::post('/update/{id}', [TaxesController::class, 'update'])->name('taxes.update');
        Route::delete('/destroy/{id}', [TaxesController::class, 'destroy'])->name('taxes.destroy');
        Route::get('/get-all', [TaxesController::class, 'getAllTaxes'])->name('taxes.getAllTaxes');
    });

    Route::prefix('working-shift-settings')->group(function () {
        Route::get('/', [WorkingShiftSettingController::class, 'index'])->name('working-shift-settings.index');
        Route::post('/store', [WorkingShiftSettingController::class, 'store'])->name('working-shift-settings.store');
        Route::put('/update/{id}', [WorkingShiftSettingController::class, 'update'])->name('working-shift-settings.update');
        Route::delete('/destroy/{id}', [WorkingShiftSettingController::class, 'destroy'])->name('working-shift-settings.destroy');
        Route::get('/get-all', [WorkingShiftSettingController::class, 'getAllWorkingShiftSettings'])->name('working-shift-settings.getAllWorkingShiftSettings');
    });

    // # Khai báo hợp đồng
    Route::prefix('hrm-contracts')->group(function () {
        Route::get('/', [HrmContractController::class, 'index'])->name('hrm-contracts.index');
        Route::post('/store', [HrmContractController::class, 'store'])->name('hrm-contracts.store');
        Route::put('/update/{id}', [HrmContractController::class, 'update'])->name('hrm-contracts.update');
        Route::delete('/destroy/{id}', [HrmContractController::class, 'destroy'])->name('hrm-contracts.destroy');
        Route::get('/get-all', [HrmContractController::class, 'getAllHrmContracts'])->name('hrm-contracts.getAllHrmContracts');
    });

//    // # Khai báo bảo hiểm
//    Route::prefix('insurances')->group(function () {
//        Route::get('/', [SettingController::class, 'index'])->name('insurances.index');
//        Route::post('/store', [SettingController::class, 'store'])->name('insurances.store');
//        Route::post('/update/{id}', [SettingController::class, 'update'])->name('insurances.update');
//        Route::delete('/destroy/{id}', [SettingController::class, 'destroy'])->name('insurances.destroy');
//        Route::get('/get-all', [SettingController::class, 'getAllTaxes'])->name('insurances.getAllTaxes');
//    });
});

Route::name('admin.')->prefix('/')->middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'getLogin'])->name('login');
    Route::post('check-login', [LoginController::class, 'postLogin'])->name('check.login');

});

Route::get('/403-page', function(){
    return view('page-errors.403');
})->name('403-error');

Route::get('/404-page', function(){
    return view('page-errors.404');
})->name('404-error');


Route::any('{url}', function(){
    return redirect('/dashboard');
    // return view('page-errors.404');
})->where('url', '.*');


