<?php

namespace App\Transformers;

use App\Enums\CustomerEnum;
use App\Enums\SystemPermissionEnum;
use App\Models\Customer;
use League\Fractal\TransformerAbstract;

use function App\Helper\check_user_permission;

class CustomerTransformer extends TransformerAbstract
{
    protected $option;
    public function __construct($option = [])
    {
        $this->option = $option;
    }
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Customer $entry)
    {
        $data = [
            'id' => $entry->id,
            'code' => $entry->code,
            'name' => $entry->name,
            'tax_code' => $entry->tax_code,
            'address' => $entry->address,
            'city_id' => $entry->city_id,
            'district_id' => $entry->district_id,
            'ward_id' => $entry->ward_id,
            'full_address' => $entry->getFullAddress(),
            'status_id' => $entry->status_id,
            'bank_number' => $entry->bank_number,
            'bank_username' => $entry->bank_username,
            'bank_id' => $entry->bank_id,
            'note' => $entry->note,
            'user_id' => $entry->user_id,
            'customer_type' => $entry->customer_type,
            'created_at_view' => $entry->created_at ? $entry->created_at->format('d/m/Y') : '',
            'created_at' => $entry->created_at ? $entry->created_at->format('Y-m-d') : '',
            'is_edit' => $this->checkCustomerCanEdit($entry),
        ];

        if (check_user_permission(SystemPermissionEnum::VIEW_CUSTOMER_CONTACT)) {
            $data = array_merge($data, [
                'representative_name' => $entry->representative_name,
            ]);
        }
        if (check_user_permission(SystemPermissionEnum::VIEW_CUSTOMER_PHONE)) {
            $data = array_merge($data, [
                'representative_phone' => $entry->representative_phone,
                'representative_email' => $entry->representative_email,
            ]);
        }

        if ($entry->relationLoaded('status')) {
            $data = array_merge($data, [
                'status' => fractal($entry->status, new SystemStatusTransformer())->toArray(),
            ]);
        }

        if ($entry->relationLoaded('banks')) {
            $data = array_merge($data, [
                'banks' => fractal($entry->bank, new BankTransformer())->toArray(),
            ]);
        }
        if ($entry->relationLoaded('city')) {
            $data = array_merge($data, [
                'city' => fractal($entry->city, new CityTransformer())->toArray(),
            ]);
        }

        if ($entry->relationLoaded('district')) {
            $data = array_merge($data, [
                'district' => fractal($entry->district, new DistrictTransformer())->toArray(),
            ]);
        }

        if ($entry->relationLoaded('ward')) {
            $data = array_merge($data, [
                'ward' => fractal($entry->ward, new WardTransformer())->toArray(),
            ]);
        }

        if ($entry->relationLoaded('user')) {
            $data = array_merge($data, [
                'user' => fractal($entry->user, new UserTransformer())->toArray(),
            ]);
        }

        if (array_key_exists('is_delete', $this->option) && $this->option['is_delete'] === true) {
            $delete = $entry->created_by == auth()->user()->id || check_user_permission(SystemPermissionEnum::DELETE_CUSTOMER);
            if ($entry->customer_type == CustomerEnum::CUSTOMER_VIP) {
                $delete = check_user_permission(SystemPermissionEnum::CUD_CUSTOMER_VIP);
            }
            if ($entry->contracts->count() > 0 || $entry->projects->count() > 0) {
                $delete = false;
            }
            $data = array_merge($data, [
                'is_delete' => $delete
            ]);
        }

        return $data;
    }

    public function checkCustomerCanEdit(Customer $entry)
    {
        if ($entry->customer_type == CustomerEnum::CUSTOMER_VIP) {
            return check_user_permission(SystemPermissionEnum::CUD_CUSTOMER_VIP);
        }
        return check_user_permission(SystemPermissionEnum::EDIT_CUSTOMER) || $entry->created_by == auth()->user()->id;
    }
}
