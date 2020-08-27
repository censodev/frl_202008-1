<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBannerRequest extends FormRequest
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
            'images'       =>  'required',
            'title_image'  =>  'required',
            'alt_image'    =>  'required'
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
            'name'         =>  __('Tên đối tác'),
            'images'       =>  __('Logo đối tác'),
            'title_image'  =>  __('Tiêu đề hình ảnh'),
            'alt_image'    =>  __('Mô tả hình ảnh')
        ];
    }
}
