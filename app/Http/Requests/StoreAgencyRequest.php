<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAgencyRequest extends FormRequest
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
            'name'         =>  'required|min:2|unique:agencys,name,'.($this->id ?? ''),
            'email'         =>  'required|min:2|unique:agencys,email,'.($this->id ?? '')
        ];
    }

    public function messages() {
        return [
            'required'              =>  __(':attribute không được để trống.'),
            'min'                   =>  __(':attribute tối thiểu 2 ký tự.'),
            'unique'                =>  __(':attribute đã tồn tại trong hệ thống, vui lòng nhập :attribute khác.'),
            'name.name'          =>  __(':attribute "'.$this->name.'" đã tồn tại trong hệ thống, vui lòng nhập :attribute khác.'),
            'email.name'          =>  __(':attribute "'.$this->email.'" đã tồn tại trong hệ thống, vui lòng nhập :attribute khác.'),
        ];
    }

    public function attributes() {
        return [
            'name'         =>  __('Tên bài viết'),
            'email'         =>  __('Email'),
        ];
    }
}
