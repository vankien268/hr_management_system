<?php

namespace App\Models;

use App\Traits\ProjectPermission;
use App\Traits\QuoteTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quote extends BaseModel
{
    use QuoteTrait, ProjectPermission;
    protected $table = 'quotes';
    protected $fillable = [
        'code',
        'title',
        'contract_type_id',
        'project_id',
        'customer_id',
        'approve_id',
        'quote_date',
        'receiver',
        'email',
        'phone',
        'note',
        'status',
        'total_amount'
    ];

    /**
     * Get the contractType that owns the Quote
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contractType(): BelongsTo
    {
        return $this->belongsTo(ContractType::class);
    }

    /**
     * Get the project that owns the Quote
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    /**
     * Get the customer that owns the Quote
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    /**
     * Get the approveBy that owns the Quote
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function approveBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approve_id');
    }

    /**
     * Get all of the quoteProduct for the Quote
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details(): HasMany
    {
        return $this->hasMany(QuoteProduct::class);
    }
    public function getListStatus($status): array
    {
        switch ($status) {
            case '0':
                return [
                    [
                        'value' => 0,
                        'name' => 'Chưa duyệt'
                    ],
                    [
                        'value' => 1,
                        'name' => 'Đã duyệt'
                    ],
                    [
                        'value' => 2,
                        'name' => 'Đã hủy'
                    ]
                ];
            case '1':
                return [
                    [
                        'value' => 1,
                        'name' => 'Đã duyệt'
                    ],
                    [
                        'value' => 0,
                        'name' => 'Chưa duyệt'
                    ]
                ];
            case '2':
                return [
                    [
                        'value' => 0,
                        'name' => 'Chưa duyệt'
                    ],
                    [
                        'value' => 2,
                        'name' => 'Đã hủy'
                    ]
                ];
            default:
                return [
                    [
                        'value' => 0,
                        'name' => 'Chưa duyệt'
                    ],
                    [
                        'value' => 1,
                        'name' => 'Đã duyệt'
                    ],
                    [
                        'value' => 2,
                        'name' => 'Đã hủy'
                    ]
                ];
        }
    }
}
