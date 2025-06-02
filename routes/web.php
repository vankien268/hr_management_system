<?php

use App\Http\Controllers\Admin\AllowanceController;
use App\Http\Controllers\Admin\ContractController;
use App\Http\Controllers\Admin\ContractTypeController;
use App\Http\Controllers\Admin\HrmContactController;
use App\Http\Controllers\Admin\HrmContractController;
use App\Http\Controllers\Admin\InsuranceController;
use App\Http\Controllers\Admin\InternalFundController;
use App\Http\Controllers\Admin\RequestTicketController;
use App\Http\Controllers\Admin\SalariesController;
use App\Http\Controllers\Admin\SalaryGradeController;
use App\Http\Controllers\Admin\TaxesController;
use App\Http\Controllers\Admin\TimekeepingController;
use App\Http\Controllers\Admin\TimeKeepingUserController;
use App\Http\Controllers\Admin\UserLeaveDayController;
use App\Http\Controllers\Admin\WorkflowController;
use App\Http\Controllers\Admin\WorkingShiftSettingController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\PayRollController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BankController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\SystemFuntionController;


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

    Route::get('/user-statistics', [Controller::class, 'getUserStatistics']);
    Route::get('/user-by-department-statistics', [Controller::class, 'getUserByDepartmentStatistics']);

    Route::prefix('contracts')->group(function () {
        Route::get('/', [ContractController::class, 'view'])->name('contract.view');

        Route::get('/types', [ContractTypeController::class, 'view'])->name('contract_type.view');
        Route::resource('/types/api', ContractTypeController::class);
    });

    Route::prefix('system-functions')->group(function () {
        Route::get('/', [SystemFuntionController::class, 'view'])->name('system_function.view');
        Route::resource('/api', SystemFuntionController::class);
    });

    Route::prefix('departments')->group(function () {
        Route::get('/', [DepartmentController::class, 'index'])->name('departments.index');
        Route::post('/store', [DepartmentController::class, 'store'])->name('departments.store');
        Route::post('/update/{id}', [DepartmentController::class, 'update'])->name('departments.update');
        Route::delete('/destroy/{id}', [DepartmentController::class, 'destroy'])->name('departments.destroy');
        Route::get('/get-all', [DepartmentController::class, 'getAllDepartments'])->name('departments.getAllDepartments');
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

    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index');
        Route::post('/store', [RoleController::class, 'store'])->name('roles.store');
        Route::post('/update/{id}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/destroy/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
        Route::get('/get-all', [RoleController::class, 'getAllRoles'])->name('roles.getAllRoles');
    });


    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    // Notification
    Route::prefix('notification')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('notification.index');
        Route::get('/get-all', [NotificationController::class, 'getNotificationAll']);
        Route::post('/read-notification/{id}', [NotificationController::class, 'maskReadNotificationById']);
    });

    Route::post('/update-mask-read', [NotificationController::class, 'maskReadNotification']);

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
        Route::get('/show-detail-timekeeping', [TimekeepingController::class, 'showDetailTimekeeping'])->name('timekeepings.showDetailTimekeeping');
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

    Route::prefix('insurances')->group(function () {
        Route::get('/', [InsuranceController::class, 'index'])->name('insurances.index');
        Route::put('/update', [InsuranceController::class, 'update'])->name('insurances.update');
        Route::get('/get-all', [InsuranceController::class, 'getAllInsurances'])->name('insurances.getAllInsurances');
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

    Route::prefix('salaries')->group(function () {
        Route::get('/', [SalariesController::class, 'index'])->name('salaries.index');
        Route::post('/store', [SalariesController::class, 'store'])->name('salaries.store');
        Route::put('/update/{id}', [SalariesController::class, 'update'])->name('salaries.update');
        Route::delete('/destroy/{id}', [SalariesController::class, 'destroy'])->name('salaries.destroy');
        Route::get('/get-all', [SalariesController::class, 'getAllSalaries'])->name('salaries.getAllSalaries');
        Route::get('/salary-contacts', [SalariesController::class, 'salaryContacts'])->name('salaries.salaryContacts');
        Route::get('/get-salary-contacts', [SalariesController::class, 'getSalaryContacts'])->name('salaries.getSalaryContacts');
    });

    Route::prefix('pay-rolls')->group(function () {
        Route::get('/', [PayRollController::class, 'index'])->name('pay-rolls.index');
        Route::post('/store', [PayRollController::class, 'store'])->name('pay-rolls.store');
        Route::put('/update/{id}', [PayRollController::class, 'update'])->name('pay-rolls.update');
        Route::delete('/destroy/{id}', [PayRollController::class, 'destroy'])->name('pay-rolls.destroy');
        Route::get('/get-all', [PayRollController::class, 'getAllPayRolls'])->name('pay-rolls.getAllPayRolls');
    });
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


