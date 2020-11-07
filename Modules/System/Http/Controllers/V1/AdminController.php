<?php


namespace Modules\System\Http\Controllers\V1;


use App\Http\Controllers\Controller;
use App\Facades\Admin as AdminFacade;
use Illuminate\Http\Request;
use Modules\System\Http\Requests\StoreAdmin;
use Modules\System\Services\Admin;
use Modules\System\Entities\Manager\Admin as AdminEntity;

class AdminController extends Controller
{
    public function list(Request $request)
    {
        $res = ['total' => 0, 'list' => []];
        $query = AdminEntity::query()->withTrashed()
            ->when($request->id, function ($query) use ($request) {
                return $query->whereId($request->id);
            })->when($request->username, function ($query) use ($request) {
                return $query->where('username', 'like', "{$request->username}%");
            })->when($request->name, function ($query) use ($request) {
                return $query->where('name', 'like', "{$request->name}%");
            });

        if (!$res['total'] = $query->count()) {
            return success($res);
        }

        $res['list'] = $query->when($request->limit && $request->page, function ($query) use ($request) {
            return $query->offset(($request->page - 1) * $request->limit)->limit($request->limit);
        })->orderByDesc('id')
            ->get(['id', 'name', 'username', 'deleted_at', 'created_at', 'updated_at'])
            ->toArray();

        return success($res);
    }

    public function create(StoreAdmin $request)
    {
        $params = $request->only(['username', 'name', 'password']);
        $params['password'] = bcrypt($params['password']);
        Admin::add($params);
        return success();
    }

    public function detail(int $id)
    {
        $admin = AdminEntity::withTrashed()->findOrFail($id, ['id', 'name', 'username'])->toArray();
        return success($admin);
    }

    public function edit(int $id, StoreAdmin $request)
    {
        $admin = AdminEntity::findOrFail($id, ['id']);
        $params = [
            'name' => $request->name,
            'username' => $request->username
        ];

        if ($request->password) {
            $params['password'] = bcrypt($request->password);
        }
        $admin->fill($params);
        $admin->save();
        return success();
    }

    public function delete(int $id)
    {
        return AdminEntity::destroy($id) ? success() : failed('删除失败');
    }

    public function recover(int $id)
    {
        $admin = AdminEntity::withTrashed()->findOrFail($id, ['id']);
        return $admin ->restore() ? success() : failed('恢复失败');
    }

    public function info()
    {
        $admin = AdminFacade::user()->toArray();
        return success($admin);
    }
}
