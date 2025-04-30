<?php

namespace App\Observers;

use App\Models\Contract;
use App\Models\Module;
use App\Repositories\Interfaces\IAnnexContractRepository;
use App\Repositories\Interfaces\IContractModuleRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Repositories\Interfaces\IContractRepository;
use App\Repositories\Interfaces\ICustomerRepository;
use App\Repositories\Interfaces\IContractTypeRepository;
use App\Repositories\Interfaces\IPaymentDetailRepository;
use App\Repositories\Interfaces\ISystemStatusRepository;
use App\Repositories\Interfaces\IProjectManagementRepository;

class ContractObserver
{
    protected $paymentDetailRepository;
    protected $annexContractRepository;
    protected $contractModuleRepository;
    protected $contractRepository;
    public function __construct
    (
        IPaymentDetailRepository $paymentDetailRepository,
        IAnnexContractRepository $annexContractRepository,
        IContractRepository $contractRepository,
        IContractModuleRepository $contractModuleRepository,
        )
    {
        $this->contractRepository = $contractRepository;
        $this->paymentDetailRepository = $paymentDetailRepository;
        $this->annexContractRepository = $annexContractRepository;
        $this->contractModuleRepository = $contractModuleRepository;
    }
    /**
     * Handle the Contract "created" event.
     */
    public function created(Contract $contract): void
    {
        $dataStore = request()->all();
        foreach( $this->contractRepository->formatDataContractModules($dataStore['contract_modules']['data']) as $key => $item){
            $module = Module::firstOrCreate(['name' => $item['module']]);
            $module->contractModules()->create([
                'contract_id' => $contract->id,
                'value' => $item['value'],
                'note_module' => $item['note_module'],
                'status' => true,
            ]);
        }
        $contract->annexContracts()->createMany($dataStore['annex_contracts']['data']);
        foreach( $this->contractRepository->formatDataPaymentDetails($dataStore['payment_details']['data']) as $item){
            $contract->paymentDetails()->create($item);
        }
    }

    /**
     * Handle the Contract "updated" event.
     */
    public function updated(Contract $contract): void
    {
        //
    }

    /**
     * Handle the Contract "deleting" event.
     */
    public function deleting(Contract $contract): bool
    {
        $contract = $contract->load(['contractModules', 'annexContracts', 'paymentDetails']);
        if($contract->paymentDetails->count() > 0 || $contract->contractModules->count() > 0 || $contract->annexContracts->count() > 0){
            return false;
        }
        return true;
    }

    /**
     * Handle the Contract "deleted" event.
     */
    public function deleted(Contract $contract): void
    {
        //
    }

    /**
     * Handle the Contract "restored" event.
     */
    public function restored(Contract $contract): void
    {
        //
    }

    /**
     * Handle the Contract "force deleted" event.
     */
    public function forceDeleted(Contract $contract): void
    {
        //
    }
}
