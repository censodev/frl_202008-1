<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEndowRequest extends FormRequest
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
            'name'         =>  'required|min:2',
            'icon'       =>  'required',
            'description'  =>  'required',
        ];
    }

    public function messages() {
        return [
            'required'              =>  __(':attribute không được để trống.'),
            'min'                   =>  __(':attribute tối thiểu 2 ký tự.')
        ];
    }

    public function attributes() {
        return [
            'name'         =>  __('Tên ưu đãi'),
            'icon'       =>  __('Icon ưu đãi'),
            'description'  =>  __('Mô tả ưu đãi')
        ];
    }
}
