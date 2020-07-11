<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Components\User\Repositories\PermissionRepository;
use App\Components\User\Repositories\RoleRepository;
use App\Components\User\Services\PermissionService;

class PermissionController extends Controller
{
    private $permissionRepository;
    private $roleRepository;
    private $permissionService;

    public function __construct(
        PermissionRepository $permissionRepository,
        RoleRepository $roleRepository,
        PermissionService $permissionService
    )
    {
        $this->middleware('auth');

        $this->permissionRepository = $permissionRepository;
        $this->roleRepository = $roleRepository;
        $this->permissionService = $permissionService;
    }

    public function index(Request $request)
    {
        try {
            $permissions = $this->permissionRepository->getList($request->all());
            
            $data = [
                'permissions' => $permissions
            ];

            return view('permission.index',$data);
        } catch (\Exception $e) {
            $request->session()->flash('message', $e->getMessage());
            $request->session()->flash('alert-class', 'danger');
            
            return redirect()->route('admin.permissions.index');
        }
    }

    public function create()
    {
        try {
            $roles = $this->roleRepository->getAll();
    
            $data = [
                'roles' => $roles
            ];
    
            return view('permission.create', $data);
        } catch (\Exception $e) {
            $request->session()->flash('message', $e->getMessage());
            $request->session()->flash('alert-class', 'danger');
            
            return redirect()->route('admin.permissions.index');
        }
    }

    public function store(Request $request)
    {
        try {
            $permission = $this->permissionService->savePermissionAndRole($request->name, $request->role);

            if (!$permission) {
                throw new \Exception($this->permissionService->getErrors(), 400);    
            }

            $request->session()->flash('message', 'You are success save data permission!');
            $request->session()->flash('alert-class', 'success');

            return redirect()->route('admin.permissions.index');
        } catch (\Exception $e) {
            $request->session()->flash('message', $e->getMessage());
            $request->session()->flash('alert-class', 'alert-danger');

            return redirect()->route('admin.permissions.create');
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $permission = $this->permissionRepository->find($id);

            if (!$permission) {
                throw new \Exception('Permission not found', 404);
            }

            $data = [
                'permission' => $permission,
                'roles' => $this->roleRepository->getAll()
            ];

            return view('permission.edit',$data);
        } catch (\Exception $e) {
            $request->session()->flash('message', $e->getMessage());
            $request->session()->flash('alert-class', 'danger');

            return redirect()->route('admin.permissions.index');
        }
    }

    public function update(Request $request)
    {
        try {
            $permission = $this->permissionRepository->find($request->id);
    
            if (!$permission) {
                throw new \Exception('Permission not found', 404);
            }
    
            $updated = $this->permissionService->updatePermissionFromRequest($request);
    
            if (!$updated) {
                throw new \Exception($e->getMessage(), 500);
            }

            $request->session()->flash('message', 'You are success update permission!');
            $request->session()->flash('alert-class', 'success');

            return redirect()->route('admin.permissions.index');
        } catch (\Exception $e) {
            $request->session()->flash('message', $e->getMessage());
            $request->session()->flash('alert-class', 'danger');

            return redirect()->route('admin.permissions.edit',['permissionId' => $permission->id]);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $deleted = $this->permissionService->deletePermissionById($id);
    
            if (!$deleted) {
                throw new \Exception('Failed delete', 404);
            }
    
            $request->session()->flash('message', 'You are success delete permission!');
            $request->session()->flash('alert-class', 'success');
        } catch (\Exception $e) {
            $request->session()->flash('message', $e->getMessage());
            $request->session()->flash('alert-class', 'danger');
        }

        return redirect()->route('admin.permissions.index');
    }
}
