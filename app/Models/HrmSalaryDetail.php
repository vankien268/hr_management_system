<?php

namespace App\Models;

class HrmSalaryDetail
{
    public $contact_id;
    public $shift_type;
    public $salary_month;
    public $salary_year;
    public $dept_id;

    // Các thuộc tính bổ sung từ $salaryAttributesData
    protected $additionalAttributes = [];

    /**
     * Hàm khởi tạo (constructor)
     */
    public function __construct(array $attributes = [])
    {
        $this->contact_id = $attributes['contact_id'] ?? null;
        $this->shift_type = $attributes['shift_type'] ?? null;
        $this->salary_month = $attributes['salary_month'] ?? null;
        $this->salary_year = $attributes['salary_year'] ?? null;
        $this->dept_id = $attributes['dept_id'] ?? null;

        // Gán các thuộc tính mở rộng
        $this->setAdditionalAttributes($attributes);
    }

    /**
     * Cài đặt đối tượng từ mảng dữ liệu
     */
    public static function install(array $data): self
    {
        return new self($data);
    }

    /**
     * Gán các thuộc tính không nằm trong danh sách cố định
     */
    protected function setAdditionalAttributes(array $attributes)
    {
        $fixed = ['contact_id', 'shift_type', 'salary_month', 'salary_year', 'dept_id'];
        foreach ($attributes as $key => $value) {
            if (!in_array($key, $fixed)) {
                $this->additionalAttributes[$key] = $value;
            }
        }
    }

    /**
     * Lấy danh sách các thuộc tính mở rộng
     */
    public function getAdditionalAttributes(): array
    {
        return $this->additionalAttributes;
    }

    /**
     * Trả về mảng toàn bộ dữ liệu (bao gồm thuộc tính chính + mở rộng)
     */
    public function toArray(): array
    {
        return array_merge([
            'contact_id' => $this->contact_id,
            'shift_type' => $this->shift_type,
            'salary_month' => $this->salary_month,
            'salary_year' => $this->salary_year,
            'dept_id' => $this->dept_id,
        ], $this->additionalAttributes);
    }
}
