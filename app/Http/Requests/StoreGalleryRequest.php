<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGalleryRequest extends FormRequest
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
            'title'         =>  'required|min:2|unique:galleries,title,'.($this->id ?? ''),
            'alias'         =>  'unique:urls,url,'.($this->url_id ?? ''),
            'category_id'   =>  'required',
            'images'        =>  'required'
        ];
    }

    public function messages() {
        return [
            'required'              =>  __(':attribute không được để trống.'),
            'category_id.required'  =>  __('Vui lòng chọn :attribute.'),
            'min'                   =>  __(':attribute tối thiểu 2 ký tự.'),
            'unique'                =>  __(':attribute đã tồn tại trong hệ thống, vui lòng nhập :attribute khác.'),
            'title.unique'          =>  __(':attribute "'.$this->title.'" đã tồn tại trong hệ thống, vui lòng nhập :attribute khác.'),
            'alias.unique'          =>  __(':attribute "'.$this->alias.'" đã tồn tại trong hệ thống, vui lòng nhập :attribute khác.')
        ];
    }

    public function attributes() {
        return [
            'title'         =>  __('Tên bộ sưu tập'),
            'alias'         =>  __('Đường dẫn thân thiện'),
            'category_id'   =>  __('Danh mục'),
            'images'        =>  __('Hình ảnh')
        ];
    }
}
