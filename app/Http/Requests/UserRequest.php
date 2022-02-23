<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required',
            'password' => 'required',
            'email' => 'required',
            'fullname' => 'required',
            'diachi' => 'required',
            'sdt' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên đăng nhập',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'email.required' => 'Vui lòng nhập email',
            'fullname.required' => 'Vui lòng nhập tên doanh nghiệp',
            'diachi.required' => 'Vui lòng nhập địa chỉ',
            'sdt.required' => 'Vui lòng nhập số điện thoại',
        ];
    }
}
