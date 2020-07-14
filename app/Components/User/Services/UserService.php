<?php
namespace App\Components\User\Services;

use App\Components\Core\BaseService;
use App\Components\User\Repositories\UserRepository;
use App\Components\User\Repositories\RoleRepository;

class UserService extends BaseService
{
    private $userRepository;
    private $roleRepository;

    public function __construct(
        UserRepository $userRepository,
        RoleRepository $roleRepository
    )
    {
        parent::__construct();

        $this->userRepository = $userRepository;

        $this->roleRepository = $roleRepository;
    }

    public function saveUserFromRequest(array $request)
    {
        $user = $this->userRepository->create($request);

        return $user;
    }

    public function updateUserFromRequest(int $userId, array $request)
    {
        $user = $this->getUserByUserId($userId);

        $status = $this->userRepository->update($user->id, $request);

        if (!$status) {
            throw new \Exception(__('Failed update user'), 400);
        }

        return $status;
    }

    private function getUserByUserId(int $userId)
    {
        $user = $this->userRepository->find($userId);

        if (!$user) {
            throw new \Exception(__('User not found'), 404);
        }

        return $user;
    }

    public function userUpdateRoles(int $userId, array $roleNames)
    {
        $user = $this->getUserByUserId($userId);

        // checking rolesName first
        $status = true;
        foreach ($roleNames as $roleName) {
            $role = $this->roleRepository->findBy('name', $roleName);

            if (!$role) {
                $status = false;

                break;
            }
        }

        if (!$status) {
            throw new \Exception("Roles not valid");
        }

        $user->syncRoles($roleNames);

        return true;
    }
}
