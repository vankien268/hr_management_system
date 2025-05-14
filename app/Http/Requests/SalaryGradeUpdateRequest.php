<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalaryGradeUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'salary_grades.*.name' => 'required|string|max:100',
            'salary_grades.*.coefficient_one' => 'numeric',
            'salary_grades.*.value_one' => 'numeric',
            'salary_grades.*.coefficient_two' => 'numeric',
            'salary_grades.*.value_two' => 'numeric',
            'salary_grades.*.coefficient_three' => 'numeric',
            'salary_grades.*.value_three' => 'numeric',
            'salary_grades.*.coefficient_four' => 'numeric',
            'salary_grades.*.value_four' => 'numeric',
            'salary_grades.*.coefficient_five' => 'numeric',
            'salary_grades.*.value_five' => 'numeric',
            'salary_grades.*.coefficient_six' => 'numeric',
            'salary_grades.*.value_six' => 'numeric',
            'salary_grades.*.coefficient_seven' => 'numeric',
            'salary_grades.*.value_seven' => 'numeric',
            'salary_grades.*.coefficient_eight' => 'numeric',
            'salary_grades.*.basic_salary' => 'numeric',
            'salary_grades.*.attributes.performance_eight' => 'numeric',
            'salary_grades.*.attributes.performance_five' => 'numeric',
            'salary_grades.*.attributes.performance_four' => 'numeric',
            'salary_grades.*.attributes.performance_one' => 'numeric',
            'salary_grades.*.attributes.performance_seven' => 'numeric',
            'salary_grades.*.attributes.performance_six' => 'numeric',
            'salary_grades.*.attributes.performance_three' => 'numeric',
            'salary_grades.*.attributes.performance_two' => 'numeric',
        ];
    }

    public function messages()
    {
        return [
            'salary_grades.*.name.required' => 'Tên ngạch không bỏ trống.',
            'salary_grades.*.name.max' => 'Tên ngạch không quá 100 ký tự.',
        ];
    }
}
