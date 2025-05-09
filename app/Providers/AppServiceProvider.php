<?php

namespace App\Providers;

use App\Models\Quote;
use App\Models\Product;
use App\Models\Contract;
use App\Models\Customer;
use App\Models\ContractType;
use App\Models\ProductGroup;
use App\Models\Project;
use App\Models\QuoteProduct;
use App\Models\Role;
use App\Models\SystemStatus;
use App\Observers\QuoteObserver;
use App\Observers\ProductObserver;
use App\Repositories\AllowanceRepository;
use App\Repositories\HrmContactRepository;
use App\Repositories\HrmContractRepository;
use App\Repositories\InitValueRepository;
use App\Repositories\Interfaces\IAllowanceRepository;
use App\Repositories\Interfaces\IHrmContactRepository;
use App\Repositories\Interfaces\IHrmContractRepository;
use App\Repositories\Interfaces\IInitValueRepository;
use App\Repositories\Interfaces\IRequestTicketRepository;
use App\Repositories\Interfaces\ISettingRepository;
use App\Repositories\Interfaces\IWorkflowRepository;
use App\Repositories\RequestTicketRepository;
use App\Repositories\SettingRepository;
use App\Repositories\WorkflowRepository;
use Illuminate\Support\Facades\DB;
use App\Observers\ContractObserver;
use App\Observers\CustomerObserver;
use App\Repositories\BankRepository;
use App\Repositories\CityRepository;
use App\Repositories\TaskRepository;
use App\Repositories\UnitRepository;
use App\Repositories\UserRepository;
use App\Repositories\WardRepository;
use Illuminate\Support\Facades\File;
use App\Repositories\QuoteRepository;
use App\Observers\ContractTypeObserver;
use App\Observers\ProductGroupObserver;
use App\Observers\ProjectObserver;
use App\Observers\QuoteProductObserver;
use App\Observers\RoleObserver;
use App\Observers\SystemStatusObserver;
use App\Repositories\ContactRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\ContractRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\DispatchRepository;
use App\Repositories\DistrictRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\TaxFeeRateRepository;
use App\Repositories\ProjectTypeRepository;
use App\Repositories\ContractTypeRepository;
use App\Repositories\ProductGroupRepository;
use App\Repositories\QuoteProductRepository;
use App\Repositories\SystemStatusRepository;
use App\Repositories\AnnexContractRepository;
use App\Repositories\PaymentDetailRepository;
use App\Repositories\ContractModuleRepository;
use App\Repositories\AcceptanceRecordRepository;
use App\Repositories\DeploymentRecordRepository;
use App\Repositories\RoleRepository;
use App\Repositories\Interfaces\IBankRepository;
use App\Repositories\Interfaces\ICityRepository;
use App\Repositories\Interfaces\ITaskRepository;
use App\Repositories\Interfaces\IUnitRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Repositories\Interfaces\IWardRepository;
use App\Repositories\Interfaces\IQuoteRepository;
use App\Repositories\ProjectManagementRepository;
use App\Repositories\DeploymentScheduleRepository;
use App\Repositories\ActivityLogRepository;
use App\Repositories\Interfaces\IContactRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Repositories\Interfaces\IContractRepository;
use App\Repositories\Interfaces\ICustomerRepository;
use App\Repositories\Interfaces\IDispatchRepository;
use App\Repositories\Interfaces\IDistrictRepository;
use App\Repositories\Interfaces\IDepartmentRepository;
use App\Repositories\Interfaces\ITaxFeeRateRepository;
use App\Repositories\Interfaces\IProjectTypeRepository;
use App\Repositories\Interfaces\IContractTypeRepository;
use App\Repositories\Interfaces\IProductGroupRepository;
use App\Repositories\Interfaces\IQuoteProductRepository;
use App\Repositories\Interfaces\ISystemStatusRepository;
use App\Repositories\Interfaces\IAnnexContractRepository;
use App\Repositories\Interfaces\IPaymentDetailRepository;
use App\Repositories\Interfaces\IContractModuleRepository;
use App\Repositories\Interfaces\IAcceptanceRecordRepository;
use App\Repositories\Interfaces\IDeploymentRecordRepository;
use App\Repositories\Interfaces\IProjectManagementRepository;
use App\Repositories\Interfaces\IDeploymentScheduleRepository;
use App\Repositories\Interfaces\IRoleRepository;
use App\Repositories\Interfaces\IRoleSystemFunctionRepository;
use App\Repositories\Interfaces\ISystemFunctionRepository;
use App\Repositories\Interfaces\IActivityLogRepository;
use App\Repositories\Interfaces\INotificationRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\RoleSystemFunctionRepository;
use App\Repositories\SystemFunctionRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->singleton(IDepartmentRepository::class, DepartmentRepository::class);
        $this->app->singleton(ISystemStatusRepository::class, SystemStatusRepository::class);
        $this->app->singleton(IContractTypeRepository::class, ContractTypeRepository::class);
        $this->app->singleton(ICustomerRepository::class, CustomerRepository::class);
        $this->app->singleton(ICityRepository::class, CityRepository::class);
        $this->app->singleton(IDistrictRepository::class, DistrictRepository::class);
        $this->app->singleton(IWardRepository::class, WardRepository::class);
        $this->app->bind(IProjectTypeRepository::class, ProjectTypeRepository::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IBankRepository::class, BankRepository::class);
        $this->app->bind(IProjectManagementRepository::class, ProjectManagementRepository::class);
        $this->app->bind(IContactRepository::class, ContactRepository::class);
        $this->app->singleton(IContractRepository::class, ContractRepository::class);
        $this->app->singleton(IAnnexContractRepository::class, AnnexContractRepository::class);
        $this->app->singleton(IPaymentDetailRepository::class, PaymentDetailRepository::class);
        $this->app->singleton(IContractModuleRepository::class, ContractModuleRepository::class);
        $this->app->singleton(ITaskRepository::class, TaskRepository::class);
        $this->app->singleton(IUnitRepository::class, UnitRepository::class);
        $this->app->singleton(ITaxFeeRateRepository::class, TaxFeeRateRepository::class);
        $this->app->singleton(IProductRepository::class, ProductRepository::class);
        $this->app->singleton(IProductGroupRepository::class, ProductGroupRepository::class);
        $this->app->singleton(IQuoteRepository::class, QuoteRepository::class);
        $this->app->singleton(IQuoteProductRepository::class, QuoteProductRepository::class);
        $this->app->singleton(IDeploymentScheduleRepository::class, DeploymentScheduleRepository::class);
        $this->app->singleton(IDeploymentRecordRepository::class, DeploymentRecordRepository::class);
        $this->app->singleton(IAcceptanceRecordRepository::class, AcceptanceRecordRepository::class);
        $this->app->singleton(IDispatchRepository::class, DispatchRepository::class);
        $this->app->singleton(IRoleRepository::class, RoleRepository::class);
        $this->app->singleton(ISystemFunctionRepository::class, SystemFunctionRepository::class);
        $this->app->singleton(IRoleSystemFunctionRepository::class, RoleSystemFunctionRepository::class);
        $this->app->singleton(IActivityLogRepository::class, ActivityLogRepository::class);
        $this->app->singleton(INotificationRepository::class, NotificationRepository::class);
        $this->app->singleton(IAllowanceRepository::class, AllowanceRepository::class);
        $this->app->singleton(IInitValueRepository::class, InitValueRepository::class);
        $this->app->singleton(ISettingRepository::class, SettingRepository::class);
        $this->app->singleton(IRequestTicketRepository::class, RequestTicketRepository::class);
        $this->app->singleton(IWorkflowRepository::class, WorkflowRepository::class);
        $this->app->singleton(IHrmContactRepository::class, HrmContactRepository::class);
        $this->app->singleton(IHrmContractRepository::class, HrmContractRepository::class);
        Customer::observe(CustomerObserver::class);
        Contract::observe(ContractObserver::class);
        ContractType::observe(ContractTypeObserver::class);
        Product::observe(ProductObserver::class);
        ProductGroup::observe(ProductGroupObserver::class);
        QuoteProduct::observe(QuoteProductObserver::class);
        Quote::observe(QuoteObserver::class);
        Project::observe(ProjectObserver::class);
        SystemStatus::observe(SystemStatusObserver::class);
        Role::observe(RoleObserver::class);


        // if (env('APP_ENV') == 'local') {
        //     DB::listen(function ($query) {
        //         File::append(
        //             storage_path('/logs/query.log'),
        //             $query->sql . ' [' . implode(', ', $query->bindings) . ']' . PHP_EOL . $query->time . 'ms' . "\n"
        //         );
        //     });
        // }
    }
}
