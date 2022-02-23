<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SlideRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'slide_ten' => 'required',
            'slide_hinhanh' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'slide_ten.required' => 'Vui lòng nhập tên slide',
            'slide_hinhanh.required' => 'Vui lòng chọn hình ảnh slide'
        ];
    }
}
