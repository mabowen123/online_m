<?php


namespace Modules\System\Http\Controllers\V1;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);
        $credentials = $request->only(['username', 'password']);
        if ($token = auth()->attempt($credentials)) {
            return success(['token' => $token], '登录成功');
        } else {
            return failed('用户名或密码错误', -100);
        }
    }

    public function logout(Request $request)
    {
        auth()->logout();
        return success([], '退出成功');
    }
}
