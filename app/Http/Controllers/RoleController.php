<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Components\User\Repositories\RoleRepository;

class RoleController extends Controller
{
    private $roleRepository;

    public function __construct(
        RoleRepository $roleRepository
    )
    {
        $this->middleware('auth');

        $this->roleRepository = $roleRepository;
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
        
    }

    public function edit($id)
    {
        $role = $this->roleRepository->find($id);

        if (!$role) {
            throw new \Exception('Role not found', 404);
        }

        return view('role.edit',[
            'role' => $role    
        ]);
    }

    public function update(Request $request)
    {
        
    }

    public function destroy($id)
    {
        $role = $this->roleRepository->find($id);

        if (!$role) {
            throw new \Exception('Role not found', 404);
        }

        $deleted = $this->roleRepository->delete($role->id);

        if (!$deleted) {
            throw new \Exception('Failed delete', 404);
        }

        return $deleted;
    }
}
