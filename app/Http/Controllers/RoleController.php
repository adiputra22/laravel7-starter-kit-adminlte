<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Components\User\Repositories\RoleRepository;
use App\Components\User\Repositories\PermissionRepository;

class RoleController extends Controller
{
    private $roleRepository;
    private $permissionRepository;

    public function __construct(
        RoleRepository $roleRepository,
        PermissionRepository $permissionRepository
    )
    {
        $this->middleware('auth');

        $this->roleRepository = $roleRepository;

        $this->permissionRepository = $permissionRepository;
    }

    public function index(Request $request)
    {
        $roles = $this->roleRepository->getList($request->all());

        return view('role.index',[
            'roles' => $roles
        ]);
    }

    public function create()
    {
        $roles = $this->roleRepository->getAll();

        return view('role.create',[
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        try {
            $role = $this->roleRepository->create(['name' => $request->name]);

            $request->session()->flash('message', 'You are success save role data!');
            $request->session()->flash('alert-class', 'success');

            return redirect()->route('admin.roles.index');
        } catch (\Exception $e) {
            $request->session()->flash('message', $e->getMessage());
            $request->session()->flash('alert-class', 'error');

            return redirect()->route('admin.roles.index');
        }
    }

    public function edit($id)
    {
        try {
            $role = $this->roleRepository->find($id);

            if (!$role) {
                throw new \Exception('Role not found', 404);
            }

            return view('role.edit',[
                'role' => $role
            ]);
        } catch (\Exception $e) {
            $request->session()->flash('message', $e->getMessage());
            $request->session()->flash('alert-class', 'error');

            return redirect()->route('admin.roles.index');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $role = $this->roleRepository->find($id);

            if (!$role) {
                throw new \Exception('Role not found', 404);
            }

            $updated = $this->roleRepository->update($role->id, ['name' => $request->name]);

            if (!$updated) {
                throw new \Exception(__("Failed updating"), 400);
            }

            $request->session()->flash('message', 'You are success update role!');
            $request->session()->flash('alert-class', 'success');

            return redirect()->route('admin.roles.index');
        } catch (\Exception $e) {
            $request->session()->flash('message', $e->getMessage());
            $request->session()->flash('alert-class', 'error');

            return redirect()->route('admin.roles.edit',['roleId' => $role->id]);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $role = $this->roleRepository->find($id);

            if (!$role) {
                throw new \Exception('Role not found', 404);
            }

            $deleted = $this->roleRepository->delete($role->id);

            if (!$deleted) {
                throw new \Exception('Failed delete', 404);
            }

            $request->session()->flash('message', 'You are success delete role data!');
            $request->session()->flash('alert-class', 'success');

            return redirect()->route('admin.roles.index');
        } catch (\Exception $e) {
            $request->session()->flash('message', $e->getMessage());
            $request->session()->flash('alert-class', 'error');

            return redirect()->route('admin.roles.index');
        }
    }

    public function show(Request $request, $roleId)
    {
        try {
            $role = $this->roleRepository->find($roleId);

            if (!$role) {
                throw new \Exception('Role not found', 404);
            }

            $permissions = $this->permissionRepository->getAll();

            $currentRolePermissions = $this->roleRepository->getAllPermission($role);

            return view('role.show',[
                'role' => $role,
                'permissions' => $permissions,
                'currentRolePermissions' => $currentRolePermissions
            ]);
        } catch (\Exception $e) {
            $request->session()->flash('message', $e->getMessage());
            $request->session()->flash('alert-class', 'error');

            return redirect()->route('admin.roles.index');
        }
    }
}
