<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HocKyRequest extends FormRequest
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
            'hocky_ten' => 'required',
            'hocky_thoigianbatdau' => 'required',
            'hocky_thoigianketthuc' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'hocky_ten.required' => 'Vui lòng nhập tên học kỳ',
            'hocky_thoigianbatdau.required' => 'Vui lòng chọn thời gian bắt đầu',
            'hocky_thoigianketthuc.required' => 'Vui lòng chọn thời gian kết thúc',
        ];
    }
}
