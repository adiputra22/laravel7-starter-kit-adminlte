<?php
namespace App\Components\User\Repositories;

use App\Components\Core\BaseRepository;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends BaseRepository
{
    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }

    public function getList($params)
    {
        return $this->get($params,[],function($q) use ($params)
        {
            $search = (isset($params['search'])) ? $params['search'] : null;

            if ($search) {
                $q->where('name','like',"%{$search}%");
            }

            return $q;
        });
    }
}