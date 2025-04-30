<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'name' => ['required', 'max:100'],
            'unit_id' => ['required','numeric', 'exists:units,id'],
            'product_group_id' => ['required','numeric', 'exists:product_groups,id'],
            'price' => ['required', 'numeric', 'min:0', 'digits_between:1,9'],
            'note' => 'nullable|max:100',
            'status' => ['required', function($attribute, $value, $fail) {
                if(!in_array($value, [0,1])) {
                    return $fail(trans('Trạng thái sử dụng không hợp lệ !'));
                }
            }],
            'image_link' => ['nullable','file', 'mimes:png,jpg']
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('Tên sản phẩm không bỏ trống.'),
            'name.max' => trans('Tên sản phẩm không quá 100 ký tự.'),
            'status.required' => trans('Chọn trạng thái không hợp lệ.'),
            'note.max' => trans('Ghi chú không vượt quá 100 ký tự.'),
            'unit_id.required' => trans('Đơn vị không bỏ trống.'),
            'unit_id.numeric' => trans('Đơn vị không hợp lệ.'),
            'unit_id.exists' => trans('Đơn vị không tồn tại.'),

            'product_group_id.required' => trans('Nhóm sản phẩm không bỏ trống.'),
            'product_group_id.numeric' => trans('Nhóm sản phẩm không hợp lệ.'),
            'product_group_id.exists' => trans('Nhóm sản phẩm không tồn tại.'),

            'price.required' => trans('Giá sản phẩm không hợp lệ.'),
            'price.numeric' => trans('Giá sản phẩm không hợp lệ.'),
            'price.digits_between' => trans('Giá sản phẩm tối đa 9 số.'),
            'price.min' => trans('Giá sản phẩm phải >= 0.'),

            'image_link.file' => trans('Ảnh sản phẩm phải là file ảnh.'),
            'image_link.mimes' => trans('Ảnh sản phẩm phải là dạng png hoặc jpg'),
            // 'image_link.max' => trans('Ảnh sản phẩm tối đa 100 kb')
        ];
    }
}
