<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\RequiredIf;

class QuoteRequest extends FormRequest
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
        $req = $this->all();
        return [
            'from_date' => [
                new RequiredIf(array_key_exists('is_search_date', $req) && ($req['is_search_date'] === true || $req['is_search_date'] === "true"))
            ],
            'to_date' => [
                new RequiredIf(array_key_exists('is_search_date', $req) && ($req['is_search_date'] === true || $req['is_search_date'] === "true"))
            ],
        ];
    }
    public function messages()
    {
        return [
            'from_date.required' => trans('Trường dữ liệu không được để trống.'),
            'to_date.required' => trans('Trường dữ liệu không được để trống.'),
        ];
    }
}
