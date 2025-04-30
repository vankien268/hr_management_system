<?php

namespace App\Traits;

use App\Models\Module;

trait ContractTrait
{
    public function updateContractModule()
    {
        $dataUpdate = request()->all();
        $contractModuleIds = $this->contractModules->pluck('id')->toArray();
        foreach($dataUpdate['contract_modules']['data'] as $key => $item){
            $module = Module::firstOrCreate(['name' => $item['module']]);
            $item = array_merge($item, ['module_id' => $module->id]);
            if($item['id'] != 0){
                /**
                 * Cập nhật hạng mục thực hiện của hợp đồng
                 */
                $this->contractModuleRepository->update($item['id'], $item);
            }else{

                /** @var mixed
                 * TODO: thêm mới hạng mục thực hiện của hợp đồng
                 */
                $item = array_merge($item, ['contract_id' => $this->id]);
                $this->contractModuleRepository->create($item);
            }

            $index = array_search($item['id'], $contractModuleIds);
            if($index !== false){
                unset($contractModuleIds[$index]);
            }
        }
        /**
         * TODO: Xóa hạng mục thực hiện
         */
        if(count($contractModuleIds) > 0){
            $this->contractModuleRepository->destroy($contractModuleIds);
        }
    }
}
