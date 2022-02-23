<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LopRequest extends FormRequest
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
            'lop_ten' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'lop_ten.required' => 'Vui lòng nhập tên tên',
        ];
    }
}
