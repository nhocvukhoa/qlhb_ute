<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NamHocRequest extends FormRequest
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
            'namhoc_ten' => 'required',
            'namhoc_thoigianbatdau' => 'required',
            'namhoc_thoigianketthuc' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'namhoc_ten.required' => 'Vui lòng nhập tên năm học',
            'namhoc_thoigianbatdau.required' => 'Vui lòng chọn thời gian bắt đầu',
            'namhoc_thoigianketthuc.required' => 'Vui lòng chọn thời gian kết thúc',
        ];
    }
}
