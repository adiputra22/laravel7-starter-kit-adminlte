<?php
namespace App\Components\User\Services;

use App\Components\Core\BaseService;
use App\Components\User\Repositories\PermissionRepository;
use App\Components\User\Repositories\RoleRepository;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionService extends BaseService
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

    public function savePermissionAndRole(array $permissions, array $roleIds)
    {
        if (!is_array($roleIds) && count($roleIds) <= 0) {
            $this->addError('Roles empty');

            return false;
        }

        if (!is_array($permissions) && count($permissions) <= 0) {
            $this->addError('Permission empty');

            return false;
        }

        try {
            DB::beginTransaction();

            foreach ($permissions as $permission) {
                $permission = $this->permissionRepository->create(['name' => $permission]);

                foreach ($roleIds as $roleId) {
                    $role = $this->roleRepository->find($roleId);

                    if (!$role) {
                        throw new \Exception('Role with ID ' . $roleId . ' not found');
                    }

                    $role->givePermissionTo($permission);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            $this->addError($e->getMessage());

            DB::rollBack();

            return false;
        }

        return true;
    }

    public function updatePermissionFromRequest($request)
    {
        $request = (object) $request;

        $permissionId = $request->id;

        $permission = $this->permissionRepository->find($permissionId);

        if (!$permission) {
            $this->addError(__('Permission not found'));

            return false;
        }

        $updatePermissionName = $this->permissionRepository->update($permissionId, ['name' => $request->name]);

        if (!$updatePermissionName) {
            $this->addError(__('Failed update permission'));

            return false;
        }

        // remove all roles by permission
        $this->removeAllRolesByPermission($permission);

        $roleIds = $request->role;

        // add new roles
        return $this->addRolesByPermission($permission, $roleIds);
    }

    private function removeAllRolesByPermission(Permission $permission)
    {
        $roles = $permission->roles()->get();
        
        foreach ($roles as $role) {
            $permission->removeRole($role);
        }

        return true;
    }

    private function addRolesByPermission(Permission $permission, array $roleIds) 
    {
        if (!is_array($roleIds) && count($roleIds) <= 0) {
            $this->addError('Roles empty');

            return false;
        }

        foreach ($roleIds as $roleId) {
            $role = $this->roleRepository->find($roleId);

            if (!$role) {
                throw new \Exception('Role with ID ' . $roleId . ' not found');
            }

            $role->givePermissionTo($permission);
        }

        return true;
    }

    public function deletePermissionById(int $permissionId)
    {
        $permission = $this->permissionRepository->find($permissionId);

        if (!$permission) {
            $this->addError(__('Permission not found'));

            return false;
        }

        $this->removeAllRolesByPermission($permission);

        $this->permissionRepository->delete($permission->id);

        return true;
    }
}