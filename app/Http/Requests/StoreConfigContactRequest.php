<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreConfigContactRequest extends FormRequest
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
            'title'         =>  'required|min:2|unique:config_contacts,title,'.($this->id ?? '')
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
            'title'         =>  __('Tiêu đề')
        ];
    }
}
