<?php


namespace Modules\System\Http\Controllers\V1;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        return success();
    }
}
