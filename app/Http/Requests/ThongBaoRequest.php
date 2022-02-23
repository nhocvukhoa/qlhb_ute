<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThongBaoRequest extends FormRequest
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
            'thongbao_ten' => 'required',
            'thongbao_mota' => 'required', 
            'thongbao_noidung' => 'required', 
        ];
    }

    public function messages()
    {
        return [
            'thongbao_ten.required' => 'Vui lòng nhập tên thông báo',
            'thongbao_ten.unique' => 'Tên thông báo đã tồn tại',
            'thongbao_mota.required' => 'Vui lòng nhập mô tả',
            'thongbao_noidung.required' => 'Vui lòng nhập nội dung',
        ];
    }
}
