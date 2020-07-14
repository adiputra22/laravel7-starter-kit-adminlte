<?php
namespace App\Components\User\Services;

use App\Components\Core\BaseService;
use App\Components\User\Repositories\PermissionRepository;
use App\Components\User\Repositories\RoleRepository;

class RoleService extends BaseService
{
    private $permissionRepository;
    private $roleRepository;

    public function __construct(
        PermissionRepository $permissionRepository,
        RoleRepository $roleRepository
    )
    {
        parent::__construct();

        $this->permissionRepository = $permissionRepository;
        $this->roleRepository = $roleRepository;
    }

    private function getRoleByRoleId(int $roleId)
    {
        $role = $this->roleRepository->find($roleId);

        if (!$role) {
            throw new \Exception(__("Role not found"));
        }

        return $role;
    }

    public function roleUpdatePermissions(int $roleId, array $permissions)
    {
        $role = $this->getRoleByRoleId($roleId);

        // checking rolesName first
        $status = true;
        foreach ($permissions as $permission) {
            $permission = $this->permissionRepository->findBy('name', $permission);

            if (!$permission) {
                $status = false;

                break;
            }
        }

        if (!$status) {
            throw new \Exception("Permissions not valid");
        }

        $role->syncPermissions($permissions);

        return true;
    }
}
