<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSchemaPostRequest extends FormRequest
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
            'headline'          =>  'required',
            'url'               =>  'required',
            'id_post'           =>  'required',
            'datePublished'     =>  'required',
            'dateModified'      =>  'required',
            'author_name'       =>  'required',
            'publisher_name'    =>  'required',
            'publisher_logo'    =>  'required',
            'images'            =>  'required',
            'shows'             =>  'required',
            'status'            =>  'required',
        ];
    }

    public function messages() {
        return [
            'required'              =>  __(':attribute không được để trống.'),
        ];
    }

    public function attributes() {
        return [
            'headline'              =>  __('Phần mở đầu'),
            'url'                   =>  __('url'),
            'id_post'               =>  __('Bài viết'),
            'datePublished'         =>  __('Ngày đăng'),
            'dateModified'          =>  __('Ngày chỉnh sửa'),
            'author_name'           =>  __('Tên tác giả'),
            'publisher_name'        =>  __('Tân nhà xuất bản'),
            'publisher_logo'        =>  __('Logo nhà xuất bản'),
            'images'                =>  __('Hình ảnh'),
            'shows'                 =>  __('Nơi hiển thị'),
            'status'                =>  __('Trạng thái')
        ];
    }
}
