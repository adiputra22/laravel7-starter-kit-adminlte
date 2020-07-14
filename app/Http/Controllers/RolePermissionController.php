<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Components\User\Services\RoleService;

class RolePermissionController extends Controller
{
    private $roleService;

    public function __construct(
        RoleService $roleService
    )
    {
        $this->middleware('auth');

        $this->roleService = $roleService;
    }

    public function update(Request $request, $roleId)
    {
        try {
            $this->roleService->roleUpdatePermissions($roleId, $request->post('permission'));

            $request->session()->flash('message', 'You are success update role!');
            $request->session()->flash('alert-class', 'success');

            return redirect()->route('admin.roles.show', ['roleId' => $roleId]);
        } catch (\Exception $e) {
            $request->session()->flash('message', $e->getMessage());
            $request->session()->flash('alert-class', 'error');

            return redirect()->route('admin.roles.show',['roleId' => $roleId]);
        }
    }
}
