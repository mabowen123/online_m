<?php

namespace Modules\System\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordModify extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => 'required',
            'password_new' => 'required|different:password|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,32}$/',
            'password_confirm' => 'required|same:password_new'
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'password.required' => '原密码不能为空',
            'password_new.required' => '新密码不能为空',
            'password_new.different' => '新密码不能与原密码一样',
            'password_new.regex' => '新密码为8~32个字符(字母或数字)，至少1个大写字母，1个小写字母和1个数字',
            'password_confirm.required' => '确认密码不能为空',
            'password_confirm.same' => '两次输入密码不一致'
        ];
    }
}
