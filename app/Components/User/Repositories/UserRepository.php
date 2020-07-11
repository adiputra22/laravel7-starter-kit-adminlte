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
        $listParams = [
            'paginate' => true,
            'per_page' => 10
        ];

        $params = array_merge($params, $listParams);

        return $this->get($params);
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