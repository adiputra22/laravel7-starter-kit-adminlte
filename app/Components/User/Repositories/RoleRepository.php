<?php
namespace App\Components\User\Repositories;

use App\Components\Core\BaseRepository;
use Spatie\Permission\Models\Role;

class RoleRepository extends BaseRepository
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function getList($params)
    {
        return $this->get($params, [], function($q) use ($params) {
            $search = (isset($params['search'])) ? $params['search'] : null;

            if ($search) {
                $q->where('name','like',"%{$search}%");
            }

            return $q;
        });
    }

    public function getAllPermission(Role $role)
    {
        return $role->permissions()->get();
    }
}
