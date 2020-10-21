<?php


namespace Modules\System\Http\Controllers\V1;


use App\Http\Controllers\Controller;
use Modules\System\Http\Requests\StoreAdmin;
use Modules\System\Services\Admin;

class AdminController extends Controller
{
    public function create(StoreAdmin $request)
    {
        $params = $request->only(['username', 'name', 'password']);
        $params['password'] = bcrypt($params['password']);
        Admin::add($params);
        return success();
    }
}
