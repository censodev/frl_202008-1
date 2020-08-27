<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConfigLogoRequest extends FormRequest
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
            'title'         =>  'required|min:2|unique:config_logos,title,'.($this->id ?? ''),
            'images'        =>  'required',
            'title_image'   =>  'required',
            'alt_image'     =>  'required'
        ];
    }

    public function messages() {
        return [
            'required'              =>  __(':attribute không được để trống.'),
            'min'                   =>  __(':attribute tối thiểu 2 ký tự.'),
            'unique'                =>  __(':attribute đã tồn tại trong hệ thống, vui lòng nhập :attribute khác.'),
            'title.unique'          =>  __(':attribute "'.$this->title.'" đã tồn tại trong hệ thống, vui lòng nhập :attribute khác.')
        ];
    }

    public function attributes() {
        return [
            'title'         =>  __('Tên Logo'),
            'images'        =>  __('Logo'),
            'title_image'   =>  __('Tiêu đề hình ảnh'),
            'alt_image'     =>  __('Mô tả hình ảnh')
        ];
    }
}
