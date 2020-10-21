<?php


namespace Modules\System\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\System\Entities\Manager\Admin;


class StoreAdmin extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => [
                'required',
                'regex:/^[\p{Han}A-Za-z0-9_-]{1,10}$/u'
            ],
            'username' => [
                'required',
                'regex:/^[A-Za-z][A-Za-z0-9_]{1,19}$/',
                Rule::unique((new Admin())->getTable())->ignore($this->id)
            ],
            'password' => [
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,32}$/'
            ],
            'password_confirm' => [
                'same:password'
            ]
        ];

        if (!$this->id) {
            $rules = array_merge_recursive($rules, [
                'password' => [
                    'required'
                ],
                'password_confirm' => [
                    'required'
                ]
            ]);
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => '用户姓名不能为空',
            'name.regex' => '用户姓名最多10位不包含特殊符号的字符串',
            'username.required' => '用户名不能为空',
            'username.regex' => '用户名2-20位字母开头，只能包含字母、数字、_的字符串',
            'username.unique' => '用户已存在',
            'password.required' => '密码不能为空',
            'password.regex' => '新密码为8~32个字符(字母或数字)，至少1个大写字母，1个小写字母和1个数字',
            'password_confirm.required' => '确认密码不能为空',
            'password_confirm.same' => '两次输入密码不一致'
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
}
