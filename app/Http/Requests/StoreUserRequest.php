<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\backend\User;

class StoreUserRequest extends FormRequest
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
        $user = User::find($this->users);

        switch($this->method()) {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'name'         =>  'required|min:2|unique:users,name,'.($this->id ?? ''),
                    'email'        =>  'min:2|unique:users,email,'.($this->id ?? ''),
                    'fullname'     =>  'required',
                    'password'     =>  'required'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name'         =>  'required|min:2|unique:users,name,'.($this->id ?? ''),
                    'fullname'     =>  'required'
                ];
            }
            default:break;
        }
    }

    public function messages() {
        return [
            'required'              =>  __(':attribute không được để trống.'),
            'min'                   =>  __(':attribute tối thiểu 2 ký tự.'),
            'unique'                =>  __(':attribute đã tồn tại trong hệ thống, vui lòng nhập :attribute khác.'),
            'name.unique'           =>  __(':attribute "'.$this->name.'" đã tồn tại trong hệ thống, vui lòng nhập :attribute khác.'),
            'email.unique'           =>  __(':attribute "'.$this->email.'" đã tồn tại trong hệ thống, vui lòng nhập :attribute khác.')
        ];
    }

    public function attributes() {
        return [
            'name'         =>  __('Tên đăng nhập'),
            'email'        =>  __('Email'),
            'fullname'     =>  __('Họ và Tên'),
            'password'     =>  __('Mật khẩu')
        ];
    }
}
