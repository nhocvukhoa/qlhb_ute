<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HocBongRequest extends FormRequest
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
            'hocbong_ten' => 'required',
            'hocbong_noidung' => 'required',
            'hocbong_thoigianbatdau' => 'required',
            'hocbong_thoigianketthuc' => 'required',
            'hocbong_kinhphi' => 'required',
            'hocbong_tongsoluong' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'hocbong_ten.required' => 'Vui lòng nhập tên học bổng',
            'hocbong_noidung.required' => 'Vui lòng nhập nội dung học bổng',
            'hocbong_thoigianbatdau.required' => 'Vui lòng chọn thời gian bắt đầu',
            'hocbong_thoigianketthuc.required' => 'Vui lòng chọn thời gian kết thúc',
            'hocbong_kinhphi.required' => 'Vui lòng nhập kinh phí',
            'hocbong_tongsoluong.required' => 'Vui lòng nhập tổng số suất',
        ];
    }
}
