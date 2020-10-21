<?php


namespace Modules\System\Services;

use Modules\System\Entities\Manager\Admin as AdminEntity;

class Admin
{
    public static function add(array $params)
    {
        return AdminEntity::create($params);
    }
}
