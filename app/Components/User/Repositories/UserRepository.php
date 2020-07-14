<?php
namespace App\Components\User\Repositories;

use App\Components\Core\BaseRepository;
use App\Components\User\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getListUsers($params)
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

    /**
     * delete a user by id
     *
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id)
    {
        $user = $this->model->find($id);

        if(!$user)
            return false;

        $user->roles()->detach();

        $user->delete();

        return true;
    }
}
