<?php

namespace App\Traits;

use App\Enums\CustomerEnum;

trait CustomerTrait
{
    public function getFullAddress()
    {
        $address = $this->address;
        if($this->ward_id !== null){
            if(!$this->relationLoaded('ward')){
                $this->load('ward');
            }
            $address .= ' - ' . $this->ward->prefix . ' ' . $this->ward->name;
        }
        if($this->district_id !== null){
            if(!$this->relationLoaded('district')){
                $this->load('district');
            }
            $address .= ' - ' . $this->district->name;
        }
        if($this->city_id !== null){
            if(!$this->relationLoaded('city')){
                $this->load('city');
            }
            $address .= ' - ' . $this->city->name;
        }
        return $address;
    }

}
