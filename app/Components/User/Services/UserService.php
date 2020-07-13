<?php
namespace App\Components\User\Services;

use App\Components\Core\BaseService;
use App\Components\User\Repositories\UserRepository;

class UserService extends BaseService
{
    private $userRepository;

    public function __construct(
        UserRepository $userRepository
    )
    {
        parent::__construct();

        $this->userRepository = $userRepository;
    }

    public function saveUserFromRequest(array $request)
    {
        $user = $this->userRepository->create($request);

        return $user;
    }

    public function updateUserFromRequest(int $userId, array $request)
    {
        $user = $this->userRepository->find($userId);

        if (!$user) {
            throw new \Exception(__('User not found'), 404);
        }

        $status = $this->userRepository->update($user->id, $request);

        if (!$status) {
            throw new \Exception(__('Failed update user'), 400);
        }

        return $status;
    }
}
